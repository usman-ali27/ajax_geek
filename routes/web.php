<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [StudentController::class, 'index'])->name('dashboard')->middleware('isLoggedIn');
Route::post('add-students', [StudentController::class, 'store']);
Route::get('fetchstudent', [StudentController::class, 'fetchstudent']);
Route::get('edit-students/{id}', [StudentController::class, 'editStudent']);
Route::put('update-students/{id}', [StudentController::class, 'updateStudent']);

// Route For Login
Route::get('login', [UserController::class, 'login'])->middleware('alreadyLoggedIn');
Route::post('do_login', [UserController::class, 'do_login']);

// Route For Registration
Route::get('register', [UserController::class, 'register'])->middleware('alreadyLoggedIn');
Route::post('do_register', [UserController::class, 'do_register']);

// Logout User
Route::get('logout', [UserController::class, 'logout'])->name('logout');
