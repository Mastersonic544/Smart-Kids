<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ChildController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ErpController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Auth\PasscodeLoginController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\Educateur\EducateurDashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Parent\ParentDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Superadmin\SuperadminAdminController;
use App\Http\Controllers\Superadmin\SuperadminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardRedirectController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Passcode auth for parents and educators (admin-issued 6-digit code, no email)
Route::middleware('guest')->group(function () {
    Route::get('/login/code', [PasscodeLoginController::class, 'show'])->name('passcode.show');
    Route::post('/login/code', [PasscodeLoginController::class, 'store'])->name('passcode.attempt');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Messaging (shared across all roles)
    Route::get('/messages', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/new', [MessageController::class, 'newConversation'])->name('messages.new');
    Route::get('/messages/search', [MessageController::class, 'searchUsers'])->name('messages.search');
    Route::get('/messages/{user}', [MessageController::class, 'conversation'])->name('messages.conversation');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
    Route::post('/messages/{user}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    Route::get('/messages/{user}/poll', [MessageController::class, 'poll'])->name('messages.poll');

    // Notifications
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

// ===== SUPERADMIN ROUTES =====
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/admins/{admin}/codes', [SuperadminAdminController::class, 'codes'])->name('admins.codes');
    Route::resource('admins', SuperadminAdminController::class)->only(['index', 'create', 'store', 'destroy']);
});

// ===== ADMIN ROUTES =====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('children', ChildController::class);
    Route::resource('parents', ParentController::class)->except(['show']);
    Route::post('parents/{parent}/regenerate-passcode', [ParentController::class, 'regeneratePasscode'])
        ->name('parents.regeneratePasscode');
    Route::resource('teachers', TeacherController::class);
    Route::post('teachers/{teacher}/regenerate-passcode', [TeacherController::class, 'regeneratePasscode'])
        ->name('teachers.regeneratePasscode');
    Route::resource('activities', ActivityController::class);
    Route::post('activities/{activity}/enroll', [ActivityController::class, 'enrollChild'])->name('activities.enroll');
    Route::post('activities/{activity}/attendance', [ActivityController::class, 'markAttendance'])->name('activities.attendance');
    Route::post('activities/{activity}/approve', [ActivityController::class, 'approve'])->name('activities.approve');
    Route::post('activities/{activity}/reject', [ActivityController::class, 'reject'])->name('activities.reject');
    Route::resource('meals', MealController::class)->except(['edit', 'update', 'destroy']);
    Route::resource('classrooms', ClassroomController::class);
    Route::resource('payments', PaymentController::class)->except(['create', 'store', 'show', 'destroy']);
    Route::resource('enrollments', EnrollmentController::class)->except(['create', 'store', 'show', 'destroy']);
    Route::get('/subscription', [AdminSubscriptionController::class, 'show'])->name('subscription.show');
    Route::post('/subscription/pay', [AdminSubscriptionController::class, 'pay'])->name('subscription.pay');
    Route::get('/erp', [ErpController::class, 'index'])->name('erp.index');
    Route::get('/erp/export', [ErpController::class, 'exportPdf'])->name('erp.exportPdf');
});

// ===== EDUCATOR ROUTES =====
Route::middleware(['auth', 'role:educateur'])->prefix('educateur')->name('educateur.')->group(function () {
    Route::get('/dashboard', [EducateurDashboardController::class, 'index'])->name('dashboard');
    Route::get('/students', [EducateurDashboardController::class, 'students'])->name('students');
    Route::get('/attendance', [EducateurDashboardController::class, 'attendance'])->name('attendance');
    Route::post('/attendance', [EducateurDashboardController::class, 'storeAttendance'])->name('attendance.store');
    Route::get('/activities', [EducateurDashboardController::class, 'activities'])->name('activities');
    Route::get('/activities/request', [EducateurDashboardController::class, 'requestActivityForm'])->name('activities.requestForm');
    Route::post('/activities/request', [EducateurDashboardController::class, 'submitActivityRequest'])->name('activities.requestSubmit');
});

// ===== PARENT ROUTES =====
Route::middleware(['auth', 'role:parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/meals', [ParentDashboardController::class, 'meals'])->name('meals');
    Route::get('/payments', [ParentDashboardController::class, 'payments'])->name('payments');
    Route::post('/payments/{payment}/pay', [ParentDashboardController::class, 'payNow'])->name('payments.pay');
    Route::get('/activities', [ParentDashboardController::class, 'activities'])->name('activities');
    Route::get('/teachers', [ParentDashboardController::class, 'teachers'])->name('teachers');
});

require __DIR__.'/auth.php';
