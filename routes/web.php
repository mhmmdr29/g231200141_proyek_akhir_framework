<?php

use App\Http\Controllers\mahasiswaController;
use App\Http\Controllers\SessionController;
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
Route::get('/welcome', function () {
    return view('sesi/welcome');
})->middleware('isTamu');


Route::resource('mahasiswa', mahasiswaController::class)->middleware('isLogin');

Route::get('/sesi',[SessionController::class, 'index'])->middleware('isTamu');
Route::post('/sesi/login',[SessionController::class, 'login'])->middleware('isTamu');
Route::get('/sesi/logout',[SessionController::class, 'logout']);
Route::get('/sesi/register',[SessionController::class, 'register'])->middleware('isTamu');
Route::post('/sesi/create',[SessionController::class, 'create'])->middleware('isTamu');

