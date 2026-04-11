<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\API\OtpController;
use App\Http\Controllers\API\SMSSubscriptionController;
use App\Http\Controllers\API\SubscriptionNotificationController;
use App\Http\Controllers\API\UssdSubscriptionController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\User\ContentController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\FaqController;
use App\Http\Controllers\User\InstallAppController;
use App\Http\Controllers\User\InstructionController;
use App\Http\Controllers\User\SendSmsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->name('verification.send');

Route::get('/password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm']);

Route::prefix('admin')
    ->middleware(['admin', 'auth'])
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminUserController::class, 'index'])->name('user');
        Route::get('/user-view', [AdminUserController::class, 'view']);
        Route::get('/control/{user_id}', [AdminUserController::class, 'control']);
        Route::get('/user-edit/{user_id}', [AdminUserController::class, 'userEdit']);
        Route::post('/user-edit/{user_id}', [AdminUserController::class, 'userUpdate']);
        Route::get('/login/{user_id}', [AdminUserController::class, 'login']);
    });

Route::prefix('user')
    ->middleware(['user', 'auth'])
    ->as('user.')
    ->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/instruction', [InstructionController::class, 'index'])->name('instruction');

        Route::resource('installapp', InstallAppController::class)->names([
            'index' => 'install',
        ])->except([
            'create',
            'store',
            'destroy',
            'show',
            'edit',
            'update',
        ]);

        Route::post('/install', [InstallAppController::class, 'store']);
        Route::get('/faq-generator', [FaqController::class, 'index'])->name('faq');
        Route::post('/faq_generator', [FaqController::class, 'faqGenerator']);
        Route::get('/sendsms', [SendSmsController::class, 'index'])->name('sendsms');
        Route::post('/sendsms', [SendSmsController::class, 'sendSms']);
        Route::get('/content', [ContentController::class, 'index'])->name('content');
        Route::post('/content', [ContentController::class, 'store'])->name('content');
        Route::get('/app-content/{app_id}', [ContentController::class, 'appContent']);
    });

Route::post('api/bdapps/ussd', [UssdSubscriptionController::class, 'index']);
Route::post('api/bdapps/sms', [SMSSubscriptionController::class, 'index']);
Route::post('api/bdapps/subscription-notify', [SubscriptionNotificationController::class, 'index']);
Route::post('api/bdapps/otp/request', [OtpController::class, 'requestOtp']);
Route::post('api/bdapps/otp/verify', [OtpController::class, 'verifyOtp']);

Route::middleware(['auth'])->group(function () {
    Route::get('/password-change', [PasswordController::class, 'index'])->name('password_change');
    Route::post('/password-change', [PasswordController::class, 'changePassword']);
});
