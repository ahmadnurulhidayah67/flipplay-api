<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// CRUD Media (parameter route {media})
Route::apiResource('media', MediaController::class)->parameters(['media' => 'media']);

// Pengguna
Route::apiResource('users', UserController::class)->only(['index', 'show']);

// Custom action: koleksi media milik pengguna (relasi many-to-many)
Route::get('/users/{user}/collection', [UserController::class, 'collection']);
Route::post('/users/{user}/collection', [UserController::class, 'addToCollection']);
Route::delete('/users/{user}/collection/{media}', [UserController::class, 'removeFromCollection']);
