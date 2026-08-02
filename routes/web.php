<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية (استعراض القاعات للجميع)
Route::get('/', [HallController::class, 'index'])->name('home');
Route::get('/halls/{hall}', [HallController::class, 'show'])->name('halls.show');

// المسارات المحمية بتسجيل الدخول (مع Laravel Breeze)
Route::middleware(['auth', 'verified'])->group(function () {

    // لوحة التحكم المباشرة
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- مسارات الحجوزات (Bookings) ---
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // --- مسارات التقييم والملاحظات (Reviews) ---
    Route::post('/bookings/{booking}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // --- مسارات إدارة القاعات (للمشرفين أو من لديه صلاحيات تعديل) ---
    Route::middleware(['can:edit halls'])->group(function () {
        Route::get('/halls/create', [HallController::class, 'create'])->name('halls.create');
        Route::post('/halls', [HallController::class, 'store'])->name('halls.store');
        Route::get('/halls/{hall}/edit', [HallController::class, 'edit'])->name('halls.edit');
        Route::put('/halls/{hall}', [HallController::class, 'update'])->name('halls.update');
        Route::delete('/halls/{hall}', [HallController::class, 'destroy'])->name('halls.destroy');
    });

    // مسارات الملف الشخصي المرفقة مع Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
