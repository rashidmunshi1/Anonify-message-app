<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Message routes
Route::get('/{username}', [MessageController::class, 'showForm'])->name('message.form');
Route::post('/{username}', [MessageController::class, 'store'])->name('message.store');

// Authenticated message management
Route::middleware('auth')->group(function () {
    Route::patch('/messages/{message}/read', [MessageController::class, 'markAsRead'])->name('message.read');
    Route::delete('/messages/{message}', [MessageController::class, 'delete'])->name('message.delete');
});
