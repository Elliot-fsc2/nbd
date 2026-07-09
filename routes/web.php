<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DonorController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Staff\QueueController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'form'])->name('home');
Route::post('/register', [PublicController::class, 'submit'])->middleware('throttle:public-form')->name('register');

Route::get('/queue/{event}/display', [QueueController::class, 'display'])->name('queue.display');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('hospitals', HospitalController::class)->except(['show']);
    Route::resource('events', EventController::class)->except(['show']);
    Route::get('events/{event}/donors', [EventController::class, 'donors'])->name('events.donors');

    Route::get('donors', [DonorController::class, 'index'])->name('donors.index');
    Route::get('donors/{donor}/form', [DonorController::class, 'form'])->name('donors.form');

    Route::resource('departments', DepartmentController::class)->except(['show']);
    Route::resource('courses', CourseController::class)->except(['show', 'create', 'edit']);
    Route::resource('users', UserController::class)->except(['show', 'create', 'edit']);
});

Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/queue', [QueueController::class, 'index'])->name('queue');
    Route::get('/events/{event}/queue', [QueueController::class, 'eventQueue'])->name('events.queue');
    Route::post('/events/{event}/checkin', [QueueController::class, 'checkIn'])->name('events.checkin');
    Route::post('/queue/{registration}/next', [QueueController::class, 'next'])->name('queue.next');
    Route::post('/queue/{registration}/complete', [QueueController::class, 'complete'])->name('queue.complete');
    Route::post('/queue/{registration}/skip', [QueueController::class, 'skip'])->name('queue.skip');
});
