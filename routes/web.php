<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ShowPosts;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', ShowPosts::class)->name('dashboard');

