<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class InventoryImportController extends Controller
{
    public function inventory_import(Request $request)
    {
        $database = 'fmsdbaai_prod_10282025';
        $table_master = "{$database}.inventory_masters";
        $table_serial = "{$database}.serialized_assets"; // sheet 2 table

        if ($request->isMethod('post')) {
            $request->validate([
                'file' => 'required|mimes:xls,xlsx',
            ]);

            $importedCount = 0; 
            $serialCount   = 0;
            $sheet1_map = []; // store mapping: gr_reference + line_number => db_id

            // --------------------------
            // IMPORT SHEET 1
            // --------------------------
            Excel::import(new class($table_master, $importedCount, $sheet1_map) implements ToCollection, WithHeadingRow {
                private $table;
                private $count;
                private $map;

                public function __construct($table, &$count, &$map)
                {
                    $this->table = $table;
                    $this->count = &$count;
                    $this->map = &$map;
                }

                public function collection(Collection $rows)
                {
                    foreach ($rows as $row) {
                        $row = collect($row)->mapWithKeys(fn($v,$k)=>[trim(strtolower($k)) => trim($v)])->toArray();

                        $line_number = $row['line_number'] ?? null;
                        unset($row['line_number']);

                        if(($row['treatment'] ?? '') == 'Supplies') $row['treatment'] = 'S';
                        elseif(($row['treatment'] ?? '') == 'Project') $row['treatment'] = 'P';
                        else $row['treatment'] = '';

                        if(empty($row['gr_reference']) || empty($row['gr_date']) || empty($row['item_code'])) continue;

                        // insert and get db id
                        $db_id = DB::table($this->table)->insertGetId([
                            'gr_reference' => $row['gr_reference'],
                            'gr_date'      => InventoryImportController::parseExcelDate($row['gr_date']),
                            'item_code'    => $row['item_code'],
                            'item_desc'    => $row['item_desc'] ?? null,
                            'rcv_qty'      => $row['rcv_qty'] ?? 0,
                            'onhand_qty'   => $row['onhand_qty'] ?? 0,
                            'used'         => $row['used'] ?? 0,
                            'for_repair'   => $row['for_repair'] ?? 0,
                            'retired'      => $row['retired'] ?? 0,
                            'rcv_uom'      => $row['rcv_uom'] ?? null,
                            'expiry_date'  => InventoryImportController::parseExcelDate($row['expiry_date']),
                            'treatment'    => $row['treatment'] ?? null,
                            'unit_price'   => $row['unit_price'] ?? 0,
                            'remarks'      => $row['remarks'] ?? null,
                            'gr_dtl_id'    => $row['gr_dtl_id'] ?? 0,
                            'dept_code'    => 101,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        // store mapping
                        if(!empty($row['gr_reference']) && $line_number !== null){
                            $this->map[$row['gr_reference']][$line_number] = $db_id;
                        }

                        $this->count++;
                    }
                }
            }, $request->file('file'));

            // --------------------------
            // READ SHEET 2 AND LINK TO MASTER
            // --------------------------
            $allSheets = Excel::toCollection(new class implements WithHeadingRow {
                public function collection(Collection $rows) {}
            }, $request->file('file'));

            if(isset($allSheets[1])) {
                $sheet2 = $allSheets[1];

                foreach($sheet2 as $row){
                    $row = collect($row)->mapWithKeys(fn($v,$k)=>[trim(strtolower($k)) => trim($v)])->toArray();

                    $gr_ref = $row['gr_reference'] ?? null;
                    $line_number = $row['line_number'] ?? null;

                    // find corresponding master db_id
                    $inv_id = $sheet1_map[$gr_ref][$line_number] ?? null;

                    if($inv_id){
                        // insert into serials table
                        DB::table($table_serial)->insert([
                            'gr_dtls_id' => $row['gr_dtls_id'] ?? 0,
                            'po_dtls_id' => $row['po_dtls_id'] ?? null,
                            'serial_no'  => $row['serial_no'] ?? null,
                            'warranty_no'=> $row['warranty_no'] ?? null,
                            'expiry'     => InventoryImportController::parseExcelDate($row['expiry'] ?? null),
                            'lot_no'     => $row['lot_no'] ?? null,
                            'status'     => $row['status'] ?? null,
                            'inv_id'     => $inv_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        DB::table($table_master)
                            ->where('id', $inv_id)
                            ->update(['serialized' => 'yes']);

                        $serialCount++;
                    }
                }

                Log::info('Sheet 2 processed, linked to master.');
            } else {
                Log::info('Sheet 2 not found.');
            }

return redirect()
    ->route('uploader.inventory_import')
    ->with([
        'inv_count'    => $importedCount,
        'serial_count' => $serialCount,
        'success'      => "$importedCount inventory rows and $serialCount serials imported successfully!"
    ]);
        }

$uploadedInventory = collect();
$uploadedSerial    = collect();

$invCount    = session('inv_count', 0);
$serialCount = session('serial_count', 0);

if ($invCount > 0) {
    $uploadedInventory = DB::table($table_master)
        ->latest('id')
        ->take($invCount)
        ->get();
}

if ($serialCount > 0) {
    $uploadedSerial = DB::table($table_serial)
        ->latest('id')
        ->take($serialCount)
        ->get();
}

return view(
    'uploader.inventory_import',
    compact('uploadedInventory', 'uploadedSerial')
);
    }

    public static function parseExcelDate($value)
    {
        if (empty($value)) return null;

        if (is_numeric($value)) {
            try {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        $timestamp = strtotime($value);
        return $timestamp !== false ? date('Y-m-d', $timestamp) : null;
    }
}
