<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
<<<<<<< HEAD
use App\Http\Controllers\EmployeeController;
=======
>>>>>>> be82b6f0b6878c6a4687914c8ec7a00914b9f96f
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/login', [AuthController::class, 'login']);
<<<<<<< HEAD
Route::get('/', [AuthController::class, 'show'])->name('login');

Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/fetch-employees', [EmployeeController::class, 'fetchstudent']);
Route::get('/edit-employee/{id}', [EmployeeController::class, 'edit']);
Route::put('/update-employee/{id}', [EmployeeController::class, 'update']);
Route::delete('/delete-employee/{id}', [EmployeeController::class, 'destroy']);
=======
//Route::get('/', [AuthController::class, 'show'])->name('login');
Route::get('/', function () {
    return view('employeeDropList');
});
>>>>>>> be82b6f0b6878c6a4687914c8ec7a00914b9f96f
