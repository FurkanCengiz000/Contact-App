<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactNoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::fallback(function () {
    return '<h1>Sorry, the pages does not exist</h1>';
});

Route::get('/', WelcomeController::class)->name('contacts');
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', DashboardController::class);
    Route::get('/settings/profile-information', ProfileController::class)->name('user-profile-information.edit');
    Route::get('settings/password', PasswordController::class)->name('user-password.edit');

    Route::resource('/contacts', ContactController::class);
    Route::delete('/contacts/{contact}/restore', [ContactController::class, 'restore'])
        ->name('contacts.restore')
        ->withTrashed();
    Route::delete('/contacts/{contact}/force-delete', [ContactController::class, 'forceDelete'])
        ->name('contacts.force-delete')
        ->withTrashed();

    Route::resource('/companies', CompanyController::class);
    Route::delete('/companies/{company}/restore', [CompanyController::class, 'restore'])
        ->name('companies.restore')
        ->withTrashed();
    Route::delete('/companies/{company}/force-delete', [CompanyController::class, 'forceDelete'])
        ->name('companies.force-delete')
        ->withTrashed();
    Route::resource('/tags', TagController::class);
    Route::resource('/tasks', TaskController::class);
    Route::resource('/activities', ActivityController::class)->except(
        'index',
        'show'
    );
});

Route::get('/download', function () {
    return Storage::download('post4.jpg', 'myPostPhoto.jpg');
});
