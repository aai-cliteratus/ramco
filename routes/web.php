<?php

use App\Http\Controllers\RamcoViewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

Route::get('/ramco', [RamcoViewController::class, 'index'])->name('ramco.index');
Route::get('/ramco_inq', [RamcoViewController::class, 'ramco_inq'])->name('ramco_inq.index');
Route::get('/ramco_je', [RamcoViewController::class, 'ramco_je'])->name('ramco_je.index');
Route::get('/ramco-inq/export', [RamcoViewController::class, 'ramco_inq_export'])->name('ramco_inq.export');
Route::get('/ramco-je/export', [RamcoViewController::class, 'ramco_je_export'])->name('ramco_je.export');

Route::get('/redis-test', function () {
    try {
        $redis = Redis::set('foo', 'bar', 60); // set key
        $value = Redis::get('foo');            // get key
        return $value;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});


Route::get('/', function () {
    return view('welcome');
});

