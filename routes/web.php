<?php

use App\Http\Controllers\LectureController;
use App\Http\Controllers\UserController;
use App\Models\Lecture;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Home
Route::get('/', function () {
    return Inertia::render('home', ['lectures' => Lecture::with('speaker')->get()]);
})->name('home');

Route::get('detona-div', function () {
    return Inertia::render('detona-div');
})->name('detona-div');

// Palestras
Route::get('palestras', [LectureController::class, 'index'])->name('lectures.index');

// Minhas Palestras
Route::prefix('minhas-palestras')->middleware(['auth', 'verified'])->group(function () {
    Route::get(
        '/',
        [UserController::class, 'my_lectures']
    )->name('user.lectures');

    Route::post('join', [UserController::class, 'attend_lecture'])->name('user.attend-lecture');

    Route::post('leave', [UserController::class, 'leave_lecture'])->name('user.leave-lecture');

});

Route::get('certificate/{lectureAttendance}', [UserController::class, 'certificate'])->name('user.certificate');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
