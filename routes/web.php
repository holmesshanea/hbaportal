<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRsvpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RetreatController;
use App\Http\Controllers\RetreatRsvpController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/retreats/{retreat}', [RetreatController::class, 'show'])->name('retreats.show');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Static info pages
Route::view('/faq', 'faq')->name('faq');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

// Auth scaffolding (with email verification)
Auth::routes(['verify' => true]);

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {

    // User dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');

    // Retreats tab/section
    Route::get('/dashboard/retreats', [UserDashboardController::class, 'retreatsIndex'])
        ->name('dashboard.retreats');     // <--- THIS is what redirect()->route('dashboard.retreats') needs

    // Events tab/section
    Route::get('/dashboard/events', [UserDashboardController::class, 'eventsIndex'])
        ->name('dashboard.events');       // if your controller has eventsIndex()

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

        // RETREATS
        Route::get('/retreats', [AdminDashboardController::class, 'retreatsIndex'])->name('retreats.index');
        Route::get('/retreats/create', [AdminDashboardController::class, 'retreatsCreate'])->name('retreats.create');
        Route::post('/retreats', [AdminDashboardController::class, 'retreatsStore'])->name('retreats.store');
        Route::get('/retreats/{retreat}', [AdminDashboardController::class, 'retreatsShow'])->name('retreats.show');
        Route::get('/retreats/{retreat}/edit', [AdminDashboardController::class, 'retreatsEdit'])->name('retreats.edit');
        Route::put('/retreats/{retreat}', [AdminDashboardController::class, 'retreatsUpdate'])->name('retreats.update');
        Route::delete('/retreats/{retreat}', [AdminDashboardController::class, 'retreatsDestroy'])->name('retreats.destroy');

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
Route::post('/events/{event}/rsvp', [EventRsvpController::class, 'store'])
    ->middleware('auth')
    ->name('events.rsvp.store');

Route::patch('/events/{event}/rsvp', [EventRsvpController::class, 'update'])
    ->middleware('auth')
    ->name('events.rsvp.update');

// Retreat RSVP
Route::post('/retreats/{retreat}/rsvp', [RetreatRsvpController::class, 'store'])
    ->middleware('auth')
    ->name('retreats.rsvp.store');

Route::patch('/retreats/{retreat}/rsvp', [RetreatRsvpController::class, 'update'])
    ->middleware('auth')
    ->name('retreats.rsvp.update');
