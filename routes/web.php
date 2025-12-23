<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('landing'))->name('home');

Route::get('/login', fn () => view('auth.login'))->name('login.page');
Route::get('/register', fn () => view('auth.register'))->name('register.page');

Route::get('/dashboard', fn () => view('dashboard.index'))->name('dashboard');




