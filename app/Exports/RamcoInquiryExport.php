<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RamcoInquiryExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $docNo = $this->request->doc_no;
        $month = $this->request->month;
        $year  = $this->request->year;
        $docRefType = $this->request->doc_ref1_type;
        $docRef = $this->request->doc_ref1;

        $query = DB::table('a2z_acct_inq');

        // DOC NO / ACCT CODE filter
        if (!empty($docNo)) {
            $docNos = preg_split('/[\s,]+/', $docNo);
            $docNos = array_values(array_filter(array_map('trim', $docNos)));

            if (!empty($docNos)) {
                $query->where(function ($q) use ($docNos) {
                    $q->whereIn('hdr_no', $docNos)
                      ->orWhereIn('acct_code', $docNos);
                });
            }
        }

        // DOC REF TYPE filter
        if (!empty($docRefType)) {
            $query->where('doc_ref1_type', 'like', "%$docRefType%");
        }

        // DOC REF filter
        if (!empty($docRef)) {
            $query->where('doc_ref1', 'like', "%$docRef%");
        }

        // Month filter
        if (!empty($month)) {
            $query->where('month', $month);
        }

        // Year filter
        if (!empty($year)) {
            $query->where('year', $year);
        }

        return $query
            ->orderBy('hdr_no', 'desc')
            ->get([
                'hdr_no',
                'finance_book',
                'acct_code',
                DB::raw("CASE WHEN php_amt > 0 THEN php_amt ELSE 0 END as dr"),
                DB::raw("CASE WHEN php_amt < 0 THEN ABS(php_amt) ELSE 0 END as cr"),
                'trans_type',
                'cost_center',
                'analysis_code',
                'sub_analysis_code',
                'doc_ref1_type',
                'doc_ref1',
                'month',
                'year',
                'supplier_code',
                'supplier_name',
                'narration',
                'created_by',
            ]);
    }

    public function headings(): array
    {
        return [
            'HDR No',
            'Finance Book',
            'Account Code',
            'DR',
            'CR',
            'Trans Type',
            'Cost Center',
            'Analysis Code',
            'Sub Analysis',
            'Doc Ref Type',
            'Doc Ref',
            'Month',
            'Year',
            'Supplier Code',
            'Supplier Name',
            'Remarks',
            'Created By',
        ];
    }
}
