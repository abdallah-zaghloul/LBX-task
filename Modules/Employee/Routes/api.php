<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Employee\Http\Controllers\EmployeeController;
use Modules\Employee\Http\Controllers\ExcelSheetController;

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

Route::group([
    'prefix' => 'employee',
    'as'=> 'employee.'
], function (){
    Route::post('/', [EmployeeController::class, 'import'])->name('import');
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('/{id}', [EmployeeController::class, 'show'])->name('show');
});

Route::group([
    'prefix' => 'excelSheet',
    'as'=> 'excelSheet.'
], function (){
    Route::get('/{id}', ExcelSheetController::class)->name('show');
});
