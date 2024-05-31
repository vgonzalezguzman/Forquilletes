<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return Inertia::render('Home');
});


Route::get('/register', function () {return Inertia::render('Register');});
Route::post('/register/send', [UserController::class, 'register'])->name('register');
Route::get('/login', function () {return Inertia::render('Login');});
Route::post('/login/send', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('delete');
Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
