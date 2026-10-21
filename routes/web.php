<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — HealthCare
|--------------------------------------------------------------------------
*/

Route::get('/', [ChatController::class, 'index'])->name('chat.index');

Route::post('/chat', [ChatController::class, 'send'])
    ->middleware('throttle:10,1')   // max 10 request/menit
    ->name('chat.send');