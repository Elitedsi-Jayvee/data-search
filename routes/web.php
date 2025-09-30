<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
Route::get('/', function () {
    return view('welcome');
});

Route::controller(SearchController::class)->group(function () {

    Route::post('/search', 'search');

});
