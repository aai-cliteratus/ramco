<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RamcoJeExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $docNo = trim($this->request->doc_no);
        $month = $this->request->month;
        $year  = $this->request->year;

        $query = DB::table('a2z_je');

        if (!empty($docNo)) {
            $docNos = collect(explode(',', $docNo))
                        ->map(fn($d) => trim($d))
                        ->filter()
                        ->toArray();

            $query->where(function ($q) use ($docNos) {
                $q->whereIn('gl_number', $docNos)
                  ->orWhereIn('acct_code', $docNos);
            });
        }

        if (!empty($month)) {
            $query->where('fiscal_period', $month);
        }

        if (!empty($year)) {
            $query->where('fiscal_year', $year);
        }

        return $query
            ->orderBy('gl_number', 'desc')
            ->get([
                'gl_number',
                'je_number',
                'acct_code',
                'php_amt',
                'usd_amt',
                'exrate',
                'acct_type',
                'fiscal_period',
                'fiscal_year',
                'preparer_id',
                'approver_id',
                'je_remarks',
            ]);
    }

    public function headings(): array
    {
        return [
            'GL Number',
            'JE Number',
            'Account Code',
            'PHP Amount',
            'USD Amount',
            'Exrate',
            'Account Type',
            'Fiscal Period',
            'Fiscal Year',
            'Prepared By',
            'Approved By',
            'JE Remarks',
        ];
    }
}
