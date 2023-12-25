<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\LoginRegisterController;
use app\Http\Controllers\CompanyController;
use app\Http\Controllers\EmployeeController;

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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('all-companies', [App\Http\Controllers\CompanyController::class, 'index']);
    Route::post('company/create', [App\Http\Controllers\CompanyController::class, 'store']);
    Route::post('company/update/{id}', [App\Http\Controllers\CompanyController::class, 'update']);
    Route::post('company/delete/{id}', [App\Http\Controllers\CompanyController::class, 'destroy']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('all-employees', [App\Http\Controllers\EmployeeController::class, 'index']);
    Route::post('employee/create', [App\Http\Controllers\EmployeeController::class, 'store']);
    Route::post('employee/update/{id}', [App\Http\Controllers\EmployeeController::class, 'update']);
    Route::post('employee/delete/{id}', [App\Http\Controllers\EmployeeController::class, 'destroy']);
});
Route::post('register', [App\Http\Controllers\LoginRegisterController::class, 'register']);
Route::post('login', [App\Http\Controllers\LoginRegisterController::class, 'login']);
Route::post('logout', [App\Http\Controllers\LoginRegisterController::class, 'logout']);
