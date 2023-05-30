<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\EmployeeController;
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
Route::get('/', [AuthController::class, 'show'])->name('login');
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/login', [AuthController::class, 'login']);

/* Route::resource provides get, post, put, and delete routes to the employee controller, 
which is used  with the ajax calls in the 'employeeCrud.js' Javascript file to perform CRUD operations */
Route::resource('/employees', EmployeeController::class)->middleware('auth');
Route::get('/fetch-employees', [EmployeeController::class, 'fetchEmployees']);

Route::resource('/tickets', TicketController::class)->middleware('auth');
Route::get('/fetch-tickets', [TicketController::class, 'fetchTickets']);


