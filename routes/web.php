<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRsvpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Static info pages
Route::view('/code', 'code')->name('code');
Route::view('/faq', 'faq')->name('faq');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

// Auth scaffolding (with email verification)
Auth::routes(['verify' => true]);

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {



    // Admin area
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // USERS
        Route::get('/users', [AdminDashboardController::class, 'usersIndex'])->name('users.index');
        Route::get('/users/create', [AdminDashboardController::class, 'usersCreate'])->name('users.create');
        Route::post('/users', [AdminDashboardController::class, 'usersStore'])->name('users.store');
        Route::get('/users/{user}', [AdminDashboardController::class, 'usersShow'])->name('users.show');
        Route::get('/users/{user}/edit', [AdminDashboardController::class, 'usersEdit'])->name('users.edit');
        Route::put('/users/{user}', [AdminDashboardController::class, 'usersUpdate'])->name('users.update');
        Route::delete('/users/{user}', [AdminDashboardController::class, 'usersDestroy'])->name('users.destroy');

        // EVENTS
        Route::get('/events', [AdminDashboardController::class, 'eventsIndex'])->name('events.index');
        Route::get('/events/create', [AdminDashboardController::class, 'eventsCreate'])->name('events.create');
        Route::post('/events', [AdminDashboardController::class, 'eventsStore'])->name('events.store');
        Route::get('/events/{event}', [AdminDashboardController::class, 'eventsShow'])->name('events.show');
        Route::get('/events/{event}/edit', [AdminDashboardController::class, 'eventsEdit'])->name('events.edit');
        Route::put('/events/{event}', [AdminDashboardController::class, 'eventsUpdate'])->name('events.update');
        Route::delete('/events/{event}', [AdminDashboardController::class, 'eventsDestroy'])->name('events.destroy');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Contact form
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');

// Event RSVP
Route::middleware('auth')->group(function () {
    Route::get('/events/{event}/rsvp/questions', [EventRsvpController::class, 'createQuestions'])
        ->name('events.rsvp.questions');

    Route::post('/events/{event}/rsvp', [EventRsvpController::class, 'store'])
        ->name('events.rsvp.store');

    Route::patch('/events/{event}/rsvp', [EventRsvpController::class, 'update'])
        ->name('events.rsvp.update');
});
