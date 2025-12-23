<?php

namespace App\Http\Controllers;

use App\Models\RamcoView;
use App\Http\Requests\StoreRamcoViewRequest;
use App\Http\Requests\UpdateRamcoViewRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RamcoViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
// 1. Get headers
$headers = DB::table('a2z_acct_inq as ai')
    ->whereIn('ai.hdr_no', ['08JV17-000164', '08JV17-000072'])
    // ->whereNot('new_acct_code',"DELETE")
    ->get();

// 2. Get details
$details = DB::table('a2z_je as je')
    ->whereIn('je.gl_number', ['08JV17-000164', '08JV17-000072'])
    // ->whereNot('new_acct_code',"DELETE")
    ->get();


        // 3. Group details by hdr_no / gl_number
        $detailsGrouped = $details->groupBy('gl_number');

        // 4. Attach details to headers
        $results = $headers->map(function($header) use ($detailsGrouped) {
            $header->details = $detailsGrouped->get($header->hdr_no, collect());
            return $header;
        });

        // 5. Log or pass to view
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
}
