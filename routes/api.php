<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DictionaryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('dictionary')->group(function() {
    Route::post('/', [DictionaryController::class, 'upsert']);
    Route::get('/get_all_records', [DictionaryController::class, 'retrieveAll']);
    Route::get('/{key}', [DictionaryController::class, 'retrieve']);
});
