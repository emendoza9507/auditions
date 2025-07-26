<?php

use App\Http\Controllers\AuditionRegistrationController;
use App\Http\Controllers\AuditionSlotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/audition-slots', [AuditionSlotController::class, 'available']);
Route::post('/audition_registrations', [AuditionRegistrationController::class, 'store']);
Route::post('/audition_registrations_test', [AuditionRegistrationController::class, 'verify']);
