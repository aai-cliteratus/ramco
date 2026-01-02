<?php

namespace App\Http\Controllers;

use App\Models\RamcoView;
use App\Http\Requests\StoreRamcoViewRequest;
use App\Http\Requests\UpdateRamcoViewRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RamcoViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    Log::info($request->all());

    $docNosInput = $request->input('doc_no'); 
    $month = $request->input('month');        
    $year = $request->input('year');          

    // Only proceed if at least one filter is set
    if (!$docNosInput && !$month && !$year) {
        // No search yet, just return empty results
        $results = collect();
        return view('ramco.index', compact('results'));
    }

    // Explode doc_no input into array
    $docNos = collect(explode(',', $docNosInput))
                ->map(fn($d) => trim($d))
                ->filter() 
                ->toArray();

    // 1. Query headers
    $headersQuery = DB::table('a2z_acct_inq as ai');
    if (!empty($docNos)) {
        $headersQuery->whereIn('ai.hdr_no', $docNos);
    }
    if (!empty($month)) {
        $headersQuery->where('ai.month', $month);
    }
    if (!empty($year)) {
        $headersQuery->where('ai.year', $year);
    }
    $headers = $headersQuery->get();

    // 2. Query details
    $detailsQuery = DB::table('a2z_je as je');
    if (!empty($docNos)) {
        $detailsQuery->whereIn('je.gl_number', $docNos);
    }
    if (!empty($month)) {
        $detailsQuery->where('je.fiscal_period', $month);
    }
    if (!empty($year)) {
        $detailsQuery->where('je.fiscal_year', $year);
    }
    $details = $detailsQuery->get();

    // 3. Group details
    $detailsGrouped = $details->groupBy('gl_number');

    // 4. Attach details to headers
    $results = $headers->map(function($header) use ($detailsGrouped) {
        $header->details = $detailsGrouped->get($header->hdr_no, collect());
        return $header;
    });

    Log::info($results);
    return view('ramco.index', compact('results'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRamcoViewRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RamcoView $ramcoView)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RamcoView $ramcoView)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRamcoViewRequest $request, RamcoView $ramcoView)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RamcoView $ramcoView)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
public function ramco_inq(Request $request)
{
    $perPage = 20;

    // Inputs
    $docNo = $request->input('doc_no');
    $month = $request->input('month');
    $year  = $request->input('year');

    $query = DB::table('a2z_acct_inq');

    /**
     * DOC NO FILTER
     * - explode
     * - trim
     * - remove empty
     * - search hdr_no IN (...)
     * - OR acct_code IN (...)
     */
    if (!empty($docNo)) {

        // Split by comma, space, or new line
        $docNos = preg_split('/[\s,]+/', $docNo);

        // Trim + remove empty values
        $docNos = array_values(array_filter(array_map('trim', $docNos)));

        if (!empty($docNos)) {
            $query->where(function ($q) use ($docNos) {
                $q->whereIn('hdr_no', $docNos)
                  ->orWhereIn('acct_code', $docNos);
            });
        }
    }

    // Month filter
    if (!empty($month)) {
        $query->where('month', $month);
    }

    // Year filter
    if (!empty($year)) {
        $query->where('year', $year);
    }

    // Order + paginate
    $inqs = $query
        ->orderBy('hdr_no', 'desc')
        ->paginate($perPage)
        ->appends($request->query()); // keep filters on scroll

    // AJAX load-more
    if ($request->ajax()) {
        return view('ramco_inq.load_more', compact('inqs'))->render();
    }

    // Initial load
    return view('ramco_inq.index', compact('inqs'));
}

public function ramco_je(Request $request)
    {
        $perPage = 20;

        $docNo = trim($request->input('doc_no'));
        $month = $request->input('month');
        $year  = $request->input('year');

        $query = DB::table('a2z_je');

        // Doc no filter: explode by comma, trim, and whereIn gl_number or acct_code
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

        $inqs = $query->orderBy('gl_number', 'desc')
                      ->paginate($perPage)
                      ->appends($request->query());

        if ($request->ajax()) {
            return view('ramco_je.load_more', compact('inqs'))->render();
        }

        return view('ramco_je.index', compact('inqs'));
    }


}
