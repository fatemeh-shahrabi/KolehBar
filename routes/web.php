<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Welcome;
use App\Livewire\Kolak\KolakConversations;
use App\Livewire\Kolak\KolakMessages;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Destinations;
use App\Livewire\Admin\Events;
use App\Livewire\Panel\Source\Index;

Route::get('/', Welcome::class)->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/conversation', KolakConversations::class)->name('kolak.conversations');
    Route::get('/conversation/{conversation}', KolakMessages::class)->name('kolak.messages');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');
    Route::get('/destinations', Destinations::class)->name('admin.destinations');
    Route::get('/events', Events::class)->name('admin.events');
});

Route::get('/source', Index::class)
    ->name('source.index');

    Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';