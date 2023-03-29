<?php

use App\Http\Controllers\EmployeController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("employe")->group(function(){
    Route::get("all", [EmployeController::class, "all"]);
});

Route::apiResource("employe", EmployeController::class);
Route::apiResource("task", TaskController::class);
