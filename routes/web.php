<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SriLankaController;
use App\Http\Controllers\Frontend\OutboundDestinationController;
use App\Http\Controllers\Frontend\TourDetailController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ServicesController;
use App\Http\Controllers\Backend\DestinationController;
use App\Http\Controllers\Backend\ContactAdminController;
use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/srilanka', [SriLankaController::class, 'index'])->name('srilanka');
Route::get('/destinations', [OutboundDestinationController::class, 'index'])->name('outbound.destinations');
Route::get('/tours/{slug}', [TourDetailController::class, 'show'])->name('tours.show');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'sendInquiry'])->name('contact.send');

// Admin Dashboard & Auth Protected Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dedicated Admin Panel Routes
    Route::get('/admin/destinations', [DestinationController::class, 'index'])->name('admin.destinations.index');
    Route::post('/admin/destinations', [DestinationController::class, 'storeDestination'])->name('admin.destinations.store');
    Route::put('/admin/destinations/{destination}', [DestinationController::class, 'updateDestination'])->name('admin.destinations.update');
    Route::delete('/admin/destinations/{destination}', [DestinationController::class, 'destroyDestination'])->name('admin.destinations.destroy');

    Route::get('/admin/packages', [DestinationController::class, 'indexPackages'])->name('admin.packages.index');
    Route::post('/admin/packages', [DestinationController::class, 'storePackage'])->name('admin.packages.store');
    Route::delete('/admin/packages/{package}', [DestinationController::class, 'destroyPackage'])->name('admin.packages.destroy');

    Route::get('/admin/itineraries', [DestinationController::class, 'indexItineraries'])->name('admin.itineraries.index');
    Route::get('/admin/bookings', [DestinationController::class, 'indexBookings'])->name('admin.bookings.index');
    Route::get('/admin/contact', [ContactAdminController::class, 'index'])->name('admin.contact.index');
    Route::put('/admin/contact', [ContactAdminController::class, 'update'])->name('admin.contact.update');
});

require __DIR__.'/auth.php';
