<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrafficLightController;

Route::get('/', [HomeController::class, 'index']);

Route::post('trafficsignal/store', [TrafficLightController::class, 'store'])->name('trafficsignal.store');
