<?php

use App\Http\Controllers\RamcoViewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

Route::get('/ramco', [RamcoViewController::class, 'index'])->name('ramco.index');

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

