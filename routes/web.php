<?php

use App\Http\Controllers\AuditionPaymentController;
use App\Http\Controllers\AuditionRegistrationController;
use App\Http\Controllers\DefaultController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Models\Audition;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $audition = Audition::query()->where('active', true)->orderBy('created_at', 'desc')->first();

    return view('welcome', [
        'audition' => $audition
    ]);
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::get('/audition_registrations/{auditionRegistration}', [AuditionRegistrationController::class, 'show'])->name('audition_registration.show');
Route::post('/audition_registrations', [AuditionRegistrationController::class, 'store'])->name('audition_registration.store');

Route::get('/paypal/success', [AuditionPaymentController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [AuditionPaymentController::class, 'cancel'])->name('paypal.cancel');

Route::get('/privacy', [DefaultController::class, 'privacy'])->name('privacy');

require __DIR__.'/auth.php';
