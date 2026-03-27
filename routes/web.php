<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ArticleController;
use App\Http\Controllers\Public\EventController as PublicEventController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\PaymentController;
use App\Http\Controllers\Member\MaterialController;
use App\Http\Controllers\Member\EventController as MemberEventController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ArticleAdminController;
use App\Http\Controllers\Admin\EventAdminController;
use App\Http\Controllers\Admin\MemberAdminController;
use App\Http\Controllers\Admin\MaterialAdminController;
use App\Http\Controllers\Admin\AnnouncementAdminController;
use App\Http\Controllers\Admin\SettingAdminController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\OrgStructureAdminController;
use App\Http\Controllers\Admin\AnalyticsController;

// ─── PUBLIC ROUTES ───────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('tentang')->group(function () {
    Route::get('/', [AboutController::class, 'index'])->name('about');
    Route::get('/struktur-organisasi', [AboutController::class, 'structure'])->name('about.structure');
});

Route::prefix('artikel')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/{slug}', [ArticleController::class, 'show'])->name('articles.show');
});

Route::prefix('kegiatan')->group(function () {
    Route::get('/', [PublicEventController::class, 'index'])->name('events.index');
    Route::get('/{slug}', [PublicEventController::class, 'show'])->name('events.show');
});

Route::prefix('kontak')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('contact');
    Route::post('/', [ContactController::class, 'send'])->name('contact.send');
});

// ─── AUTH ROUTES ─────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── MEMBER ROUTES ────────────────────────────────────────────────────
Route::prefix('member')
    ->middleware(['auth', 'member'])
    ->name('member.')
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('pembayaran')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payment');
        Route::post('/', [PaymentController::class, 'pay'])->name('payment.pay');
        Route::post('/{id}/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
        Route::get('/history', [PaymentController::class, 'history'])->name('payment.history');
    });

    Route::prefix('materi')->group(function () {
        Route::get('/', [MaterialController::class, 'index'])->name('member.materials');
        Route::get('/{id}', [MaterialController::class, 'show'])->name('member.materials.show');
        Route::get('/{id}/download', [MaterialController::class, 'download'])->name('member.materials.download');
    });

    Route::prefix('kegiatan')->group(function () {
        Route::get('/', [MemberEventController::class, 'index'])->name('member.events');
        Route::get('/{id}', [MemberEventController::class, 'show'])->name('member.events.show');
        Route::post('/{id}/daftar', [MemberEventController::class, 'register'])->name('member.events.register');
        Route::delete('/{id}/batal', [MemberEventController::class, 'cancel'])->name('member.events.cancel');
    });
});

// ─── ADMIN ROUTES ─────────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('artikel', ArticleAdminController::class)->names('admin.articles');
    Route::resource('kegiatan', EventAdminController::class)->names('admin.events');
    Route::resource('materi', MaterialAdminController::class)->names('admin.materials');
    Route::resource('pengumuman', AnnouncementAdminController::class)->names('admin.announcements');
    Route::resource('struktur-organisasi', OrgStructureAdminController::class)->names('admin.org');

    Route::prefix('anggota')->group(function () {
        Route::get('/', [MemberAdminController::class, 'index'])->name('admin.members.index');
        Route::get('/export/excel', [MemberAdminController::class, 'exportExcel'])->name('admin.members.export'); // ← pindah ke sini
        Route::get('/{id}', [MemberAdminController::class, 'show'])->name('admin.members.show');
        Route::put('/{id}/status', [MemberAdminController::class, 'updateStatus'])->name('admin.members.status');
    });

    Route::prefix('pembayaran')->group(function () {
        Route::get('/', [MemberAdminController::class, 'payments'])->name('admin.payments.index');
        Route::put('/{id}/konfirmasi', [MemberAdminController::class, 'confirmPayment'])->name('admin.payments.confirm');
        Route::put('{id}/tolak', [MemberAdminController::class, 'rejectPayment'])->name('admin.payments.reject');
    });

    Route::prefix('pesan')->group(function () {
        Route::get('/', [ContactAdminController::class, 'index'])->name('admin.contact.index');
        Route::get('/{id}', [ContactAdminController::class, 'show'])->name('admin.contact.show');
        Route::put('/{id}/balas', [ContactAdminController::class, 'reply'])->name('admin.contact.reply');
        Route::delete('/{id}', [ContactAdminController::class, 'destroy'])->name('admin.contact.destroy');
    });

    // ✅ Settings Routes - PENTING!
    Route::get('/pengaturan', [SettingAdminController::class, 'index'])->name('admin.settings.index');
    Route::put('/pengaturan', [SettingAdminController::class, 'update'])->name('admin.settings.update');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/analytics', [AnalyticsController::class, 'index'])
        ->name('analytics.index');

    Route::get('/analytics/realtime', [AnalyticsController::class, 'realtime'])
        ->name('analytics.realtime');

    Route::post('/analytics/duration', [AnalyticsController::class, 'duration'])
        ->name('analytics.duration');
});