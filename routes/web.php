<?php

use App\Http\Controllers\CheckController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name("home");
Route::post('/check', CheckController::class)->name("check");
