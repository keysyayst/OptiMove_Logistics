<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', fn () => view('landing'))->name('home');

Route::get('/login', fn () => view('auth.login'))->name('login.page');
Route::get('/register', fn () => view('auth.register'))->name('register.page');

Route::get('/dashboard', fn () => view('dashboard.index'))->name('dashboard');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');


// Shipments
Route::get('/shipments', fn () => view('shipments.index'))->name('shipments.index');
Route::get('/shipments/create', fn () => view('shipments.create'))->name('shipments.create');
Route::get('/shipments/{id}', fn ($id) => view('shipments.show', ['id' => $id]))->name('shipments.show');
Route::get('/shipments/{id}/edit', fn ($id) => view('shipments.edit', ['id' => $id]))->name('shipments.edit');

// Tracking (Public)
Route::get('/tracking', fn () => view('tracking.index'))->name('tracking.index');
Route::get('/tracking/{uuid}', fn ($uuid) => view('tracking.index'))->name('tracking.show');
