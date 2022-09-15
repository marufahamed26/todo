<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'todo'], function (){
    Route::get('', [TodoController::class, 'index']);
    Route::post('create', [TodoController::class, 'create']);
    Route::post('update', [TodoController::class, 'update']);
    Route::post('delete', [TodoController::class, 'delete']);
    Route::post('complete', [TodoController::class, 'toggle']);
});
