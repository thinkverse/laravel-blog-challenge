<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('web')
    ->group(base_path('routes/auth.php'));
