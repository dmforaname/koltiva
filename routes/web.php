<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;

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

Route::get('/login', [Auth\LoginController::class, 'index'])->name('login');
Route::get('/register', [Auth\LoginController::class, 'register']);
Route::post('/register' , [Auth\LoginController::class, 'registerStore'])->name('Register.store');
Route::post('/login' , [Auth\LoginController::class, 'login'])->name('Login.store');
Route::get('/logout' , [Auth\LoginController::class, 'logout'])->name('userLogout');
Route::get('/user/get-token', [Auth\LoginController::class, 'getToken'])->middleware('auth');


Route::middleware(['auth'])->group(function () { 

    Route::get('/', function () {
        return view('admin.user');
    });
});

