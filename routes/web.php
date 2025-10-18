<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;


// Hiển thị form đăng nhập
Route::get('/', [LoginController::class, 'create'])->name('login');
// Xử lý dữ liệu từ form đăng nhập
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

// Hiển thị form đăng ký
Route::get('/register', [RegisterController::class, 'create'])->name('register');
// Xử lý dữ liệu từ form đăng ký
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/quiz/start', [QuizController::class, 'start'])->name('quiz.start');
Route::post('/quiz/submit', [QuizController::class, 'submit'])->name('quiz.submit');
// Route để xử lý tin nhắn từ chatbot
Route::post('/chatbot', [ChatbotController::class, 'handleMessage'])->name('chatbot.send');


Route::middleware(['auth'])->group(function () {

    // Trang chủ
    Route::get('/index', function () {
        return view('index');
    })->name('index');

    // Đăng xuất (dùng POST)
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    // Bắt đầu thi
     Route::get('/quiz/start', [QuizController::class, 'start'])->name('quiz.start');

    // Route xử lý nộp bài (đã có từ trước)
    Route::post('/quiz/submit', [QuizController::class, 'submit'])->name('quiz.submit');
    // Thi thử

    Route::get('/thi-thu', [QuizController::class, 'practice'])->name('f_quiz');
    
    // Kết quả thi
    Route::get('/result', function () {
        return view('quiz.result');
    })->name('result');


    // Route để hiển thị trang chỉnh sửa thông tin (GET)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Route để xử lý việc cập nhật thông tin (PATCH)
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

});

// Route tạm thời để xem giao diện (có thể giữ lại hoặc xóa đi)
Route::get('/preview/result', function () {
    return view('quiz.result');
})->name('preview.result');