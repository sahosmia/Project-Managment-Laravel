<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\IndustrialProposalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RCellController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile/view', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}/update', [ProjectController::class, 'update'])->name('projects.update');

    // student role
    Route::middleware(['role:student'])->group(function () {
        Route::get('/proposal-sends', [ProjectController::class, 'create'])->name('projects.create');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

         Route::get('/industrial-proposals/create', [IndustrialProposalController::class, 'create'])->name('industrial-proposals.create');
        Route::post('/industrial-proposals', [IndustrialProposalController::class, 'store'])->name('industrial-proposals.store');
    });

    // admin, faculty_member role

    Route::post('/projects/{project}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
    Route::post('/projects/{project}/reject', [ProjectController::class, 'reject'])->name('projects.reject');

    Route::get('/industrial-proposals', [IndustrialProposalController::class, 'index'])->name('industrial-proposals.index');
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::resource('departments', DepartmentController::class);
        Route::resource('companies', CompanyController::class);
        Route::resource('r_cells', RCellController::class);

        Route::get('/industrial-proposals/{industrial_proposal}/edit', [IndustrialProposalController::class, 'edit'])->name('industrial-proposals.edit');
        Route::put('/industrial-proposals/{industrial_proposal}', [IndustrialProposalController::class, 'update'])->name('industrial-proposals.update');

         Route::get('settings', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('admin.settings.update');
    });


});

require __DIR__ . '/auth.php';
