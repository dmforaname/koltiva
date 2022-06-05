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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [Auth\LoginController::class, 'index']);
Route::get('/register', [Auth\LoginController::class, 'register']);
Route::post('/register' , [Auth\LoginController::class, 'registerStore'])->name('Register.store');