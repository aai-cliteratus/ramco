<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RamcoTbExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $month = $this->request->month;
        $year  = $this->request->year;

        $query = DB::table('a2z_je')
            ->select(
                'acct_code',
                'acct_desc',
                DB::raw("SUM(CASE WHEN acct_type = 'DR' THEN php_amt ELSE 0 END) AS DR"),
                DB::raw("SUM(CASE WHEN acct_type = 'CR' THEN php_amt ELSE 0 END) AS CR")
            );

        if (!empty($month)) {
            $query->where('fiscal_period', $month);
        }

        if (!empty($year)) {
            $query->where('fiscal_year', $year);
        }

        return $query
            ->groupBy('acct_code', 'acct_desc')
            ->orderBy('acct_code')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Account Code',
            'Account Description',
            'DR Amount (PHP)',
            'CR Amount (PHP)',
        ];
    }
}
