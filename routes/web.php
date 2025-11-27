<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventApprovalController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/events', [PublicEventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [PublicEventController::class, 'show'])->name('events.show');

// Auth routes (custom login with admin design)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Protected routes - redirect to role-specific dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/contoh', [DashboardController::class, 'contoh'])->name('contoh');

    // Super Admin routes
    Route::middleware(['role:super-admin'])->prefix('dashboard/super')->name('super.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'index'])->name('dashboard');
        Route::resource('organizations', OrganizationController::class);
        Route::resource('users', UserController::class);

        // Event Approval Routes
        Route::get('events/pending', [EventApprovalController::class, 'index'])->name('events.pending');
        Route::get('events/{event}', [EventApprovalController::class, 'show'])->name('events.show');
        Route::post('events/{event}/approve', [EventApprovalController::class, 'approve'])->name('events.approve');
        Route::post('events/{event}/reject', [EventApprovalController::class, 'reject'])->name('events.reject');

        Route::resource('certificates', CertificateController::class);
        Route::resource('registrations', RegistrationController::class);
    });

    // Admin routes
    Route::middleware(['role:admin'])->prefix('dashboard/admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('organizations', OrganizationController::class)->only(['index', 'show', 'edit', 'update']);
        Route::resource('users', UserController::class);
        Route::resource('events', EventController::class);
        Route::resource('certificates', CertificateController::class);
        Route::resource('registrations', RegistrationController::class);
    });

    // User routes
    Route::middleware(['role:user'])->prefix('dashboard/user')->name('user.')->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
        // User event viewing is handled by public routes now, but maybe they have a dashboard view?
        // For now, let's keep the dashboard event resource but maybe point to public controller or a specific user controller if needed.
        // The requirement says "User Biasa... Bisa ikut event, daftar event".
        // For now, let's leave the existing resource but it might need refactoring later.
        Route::resource('events', EventController::class)->only(['index', 'show']);
        Route::resource('certificates', CertificateController::class)->only(['index', 'show']);
        Route::resource('registrations', RegistrationController::class);
    });
});
