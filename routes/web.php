<?php

use App\Http\Controllers\PageCourseDetailsController;
use App\Http\Controllers\PageDashboardController;
use App\Http\Controllers\PageHomeController;
use App\Http\Controllers\PageVideosController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', PageHomeController::class)->name('pages.home');

Route::get('courses/{course:slug}', PageCourseDetailsController::class)->name('pages.course-details');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', PageDashboardController::class)->name('pages.dashboard');
    Route::get('videos/{course:slug}/{video:slug?}', PageVideosController::class)->name('pages.course-videos');
});

Route::webhooks('webhooks');

Route::get('testing-actions', function () {
    Log::info('testing, coverage report 2');
});
