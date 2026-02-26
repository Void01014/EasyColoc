<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\MyGroupController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'dashboard');


Route::middleware('auth')->group(function () {
    Route::get('myGroup', [MyGroupController::class, 'view'])->name('myGroup.view');
    Route::get('dashboard', [DashboardController::class, 'view'])->name('dashboard');
    Route::get('invitation/{token}', [InvitationController::class, 'view'])->name('invitation.view');
    Route::post('invitation/handleAction', [InvitationController::class, 'action'])->name('invitation.handle-invite');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
