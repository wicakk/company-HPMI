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
use App\Http\Controllers\Member\JournalController as MemberJournalController;
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
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\BankAccountController;


use App\Http\Controllers\Admin\EbookController as AdminEbookController;
use App\Http\Controllers\Member\EbookController as MemberEbookController;

// ─── PUBLIC ROUTES ───────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [AboutController::class, 'index'])->name('about');
Route::get('/tentang/struktur-organisasi', [AboutController::class, 'structure'])->name('about.structure');
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/kegiatan', [PublicEventController::class, 'index'])->name('events.index');
Route::get('/kegiatan/{slug}', [PublicEventController::class, 'show'])->name('events.show');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [ContactController::class, 'send'])->name('contact.send');
Route::get('/home/research', [HomeController::class, 'researchSearch'])->name('research.search');

// ─── AUTH ROUTES ─────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
// ─── MEMBER ROUTES ────────────────────────────────────────────────────

Route::middleware(['auth', 'member'])->group(function () {
    Route::get('/member/dashboard', [DashboardController::class, 'index'])->name('member.dashboard');
    
    // Payment — nama berbeda untuk GET dan POST
    Route::get('/member/pembayaran', [PaymentController::class, 'index'])->name('member.payment');
    Route::post('/member/pembayaran', [PaymentController::class, 'pay'])->name('member.payment.pay'); // ← fix duplikat nama
    Route::post('/member/pembayaran/{id}/confirm', [PaymentController::class, 'confirm'])->name('member.payment.confirm');
    Route::get('/member/pembayaran/history', [PaymentController::class, 'history'])->name('member.payment.history');
    
    // Profile
    Route::get('/member/profile', [ProfileController::class, 'index'])->name('member.profile');  // ← fix dari member.profile.index
    Route::put('/member/profile', [ProfileController::class, 'update'])->name('member.profile.update');
    
    Route::get('/member/materi', [MaterialController::class, 'index'])->name('member.materials');
    Route::get('/member/materi/{id}', [MaterialController::class, 'show'])->name('member.materials.show');
    Route::get('/member/materi/{id}/download', [MaterialController::class, 'download'])->name('member.materials.download');
    
    Route::get('/member/kegiatan', [MemberEventController::class, 'index'])->name('member.events');
    Route::get('/member/kegiatan/{id}', [MemberEventController::class, 'show'])->name('member.events.show');
    Route::post('/member/kegiatan/{id}/daftar', [MemberEventController::class, 'register'])->name('member.events.register');
    Route::delete('/member/kegiatan/{id}/batal', [MemberEventController::class, 'cancel'])->name('member.events.cancel');
    
    Route::get('/member/ebooks', [MemberEbookController::class, 'index'])->name('member.ebooks');
    Route::get('/member/ebooks/{ebook}/download', [MemberEbookController::class, 'download'])->name('member.ebooks.download');

    // Member Journal Routes
    Route::get('/member/journals', [MemberJournalController::class, 'index'])->name('member.journals');
    Route::get('/member/journals/{journal}/download', [MemberJournalController::class, 'download'])->name('member.journals.download');
    // Route::get('/admin/journals/{journal}/download', [JournalController::class, 'download'])->name('admin.journals.download');
    });
    
    // ─── ADMIN ROUTES ─────────────────────────────────────────────────────
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('/admin/bank-accounts', BankAccountController::class)->names('admin.bank-accounts');
        
        Route::resource('/admin/artikel', ArticleAdminController::class)->names('admin.articles');
        Route::resource('/admin/kegiatan', EventAdminController::class)->names('admin.events');
        Route::resource('/admin/materi', MaterialAdminController::class)->names('admin.materials');
        Route::resource('/admin/pengumuman', AnnouncementAdminController::class)->names('admin.announcements');
        Route::resource('/admin/struktur-organisasi', OrgStructureAdminController::class)->names('admin.org');
        
        Route::get('/admin/anggota', [MemberAdminController::class, 'index'])->name('admin.members.index');
    Route::get('/admin/anggota/export/excel', [MemberAdminController::class, 'exportExcel'])->name('admin.members.export');
    Route::get('/admin/anggota/{id}', [MemberAdminController::class, 'show'])->name('admin.members.show');
    Route::put('/admin/anggota/{id}/status', [MemberAdminController::class, 'updateStatus'])->name('admin.members.status');

    Route::get('/admin/pembayaran', [MemberAdminController::class, 'payments'])->name('admin.payments.index');
    Route::put('/admin/pembayaran/{id}/konfirmasi', [MemberAdminController::class, 'confirmPayment'])->name('admin.payments.confirm');
    Route::put('/admin/pembayaran/{id}/tolak', [MemberAdminController::class, 'rejectPayment'])->name('admin.payments.reject');

    Route::get('/admin/pesan', [ContactAdminController::class, 'index'])->name('admin.contact.index');
    Route::get('/admin/pesan/{id}', [ContactAdminController::class, 'show'])->name('admin.contact.show');
    Route::put('/admin/pesan/{id}/balas', [ContactAdminController::class, 'reply'])->name('admin.contact.reply');
    Route::delete('/admin/pesan/{id}', [ContactAdminController::class, 'destroy'])->name('admin.contact.destroy');

    Route::get('/admin/pengaturan', [SettingAdminController::class, 'index'])->name('admin.settings.index');
    Route::put('/admin/pengaturan', [SettingAdminController::class, 'update'])->name('admin.settings.update');

    Route::get('/admin/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics.index');
    Route::get('/admin/analytics/realtime', [AnalyticsController::class, 'realtime'])->name('admin.analytics.realtime');
    Route::post('/admin/analytics/duration', [AnalyticsController::class, 'duration'])->name('admin.analytics.duration');

    Route::resource('/admin/journals', JournalController::class)->names('admin.journals');
    Route::get('/admin/journals/{journal}/download', [JournalController::class, 'download'])->name('admin.journals.download');
    Route::patch('/admin/journals/{journal}/toggle-publish', [JournalController::class, 'togglePublish'])->name('admin.journals.toggle-publish');


    Route::resource('/admin/categories', CategoryController::class)->names('admin.categories');
    Route::patch('/admin/categories/{category}/toggle-active', [CategoryController::class, 'toggleActive'])
     ->name('admin.categories.toggle-active');

    Route::resource('/admin/ebooks', AdminEbookController::class)->names('admin.ebooks');
    Route::patch('/admin/ebooks/{ebook}/toggle-publish', [AdminEbookController::class, 'togglePublish'])->name('admin.ebooks.toggle-publish');
    Route::get('/admin/ebooks/{ebook}/download', [AdminEbookController::class, 'download'])->name('admin.ebooks.download');
});