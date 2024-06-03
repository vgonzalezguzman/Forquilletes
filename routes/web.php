<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageLoader;
use App\Http\Controllers\RestaurantController;

use App\Http\Middleware\Session;

Route::get('/', [PageLoader::class, 'home']);

Route::get('/dashboard', [PageLoader::class, 'dashboard'])->middleware(Session::class);

Route::get('/restaurant/show/{id}', [RestaurantController::class, 'index']);
Route::get('/restaurant/create', [RestaurantController::class, 'renderCreate'])->middleware(Session::class);
Route::post('/restaurant/create/upload', [RestaurantController::class, 'create'])->middleware(Session::class);
Route::get('/restaurant/edit/{id}', [RestaurantController::class, 'editRestaurant'])->middleware(Session::class);

Route::get('/register', function () {return Inertia::render('Register');});
Route::post('/register/send', [AuthController::class, 'register'])->name('register');
Route::get('/login', function () {return Inertia::render('Login');});
Route::post('/login/send', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::delete('/delete/{user}', [AuthController::class, 'delete'])->name('delete');
Route::put('/update/{user}', [AuthController::class, 'update'])->name('update');
