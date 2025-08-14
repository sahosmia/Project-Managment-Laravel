<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RCellController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
    Route::put('/projects/{project}/update', [AdminController::class, 'updateProject'])->name('projects.update');

    Route::post('/projects/{project}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
    Route::post('/projects/{project}/reject', [ProjectController::class, 'reject'])->name('projects.reject');


    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');


    Route::middleware(['role:admin'])->group(function () {

        Route::resource('users', UserController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('r_cells', RCellController::class);


        Route::post('/projects/{project}/assign-supervisor', [AdminController::class, 'assignSupervisor'])->name('projects.assignSupervisor'); 
    });

    // Research Sell
    Route::middleware(['role:research_cell'])->prefix('research-cell')->name('research_cell.')->group(function () {

    });

    Route::middleware(['role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    });

    Route::middleware(['role:student'])->group(function () {
        Route::get('/proposal-sends', [ProjectController::class, 'create'])->name('projects.create');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');        
    });

    
});

require __DIR__ . '/auth.php';
