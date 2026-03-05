<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Admin-only pages
    Route::middleware(['can:admin'])->group(function () {
            Route::view('admin/events', 'admin.events')->name('admin.events');
            Route::view('admin/users', 'admin.users')->name('admin.users');
        }
        );    });

require __DIR__ . '/settings.php';
