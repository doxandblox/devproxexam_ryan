<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CsvController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

Route::get('/features', function () {
    return view('features');
});

//Student index and forms
Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/add', [StudentController::class, 'add']);
//Student Store / Update
Route::post('/students/store', [StudentController::class, 'store']);
//CSV Management
Route::get('/csv',[CsvController::class,'index']);
Route::get('/csv-entries',[CsvController::class,'csvEntries']);
Route::post('/build-csv',[CsvController::class,'buildCSV']);
Route::post('process-csv',[CsvController::class,'processCSV']);
Route::get('/remove-csv',[CsvController::class,'removeCSV']);
