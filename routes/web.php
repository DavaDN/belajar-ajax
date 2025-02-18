<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;

Route::get('/', function () {
    return view('welcome');
});


Route::view('/login', 'login')->name('login');
Route::view('/register', 'register')->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/home', function () {
    return view('home');
})->middleware('auth');


Route::get('/api/home-data', [DataController::class, 'index'])->middleware('auth');

Route::post('/data/store', [DataController::class, 'store'])->middleware('auth');
Route::delete('/data/delete/{id}', [DataController::class, 'destroy'])->middleware('auth');
