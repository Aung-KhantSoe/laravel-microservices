<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContractController;
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

// Route::get('contracts',[ContractController::class, 'contracts']);
// Route::get('getContract/{id}',[ContractController::class, 'getContract']);
// Route::post('updateContract/{id}',[ContractController::class, 'updateContract']);
// Route::post('saveContract',[ContractController::class, 'saveContract']);
// Route::delete('deleteContract/{id}',[ContractController::class, 'deleteContract']);

// Route::apiResource('users', UserController::class);
Route::apiResource('contracts', ContractController::class);

// Additional contract routes
Route::get('contracts/status/{status}', [ContractController::class, 'byStatus']);
