<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\UserMediaController;

Route::apiResource('media', MediaController::class);

Route::get('/users/{user}/media', [UserMediaController::class, 'index']);
Route::post('/users/{user}/media', [UserMediaController::class, 'store']);
Route::delete('/users/{user}/media/{media}', [UserMediaController::class, 'destroy']);
