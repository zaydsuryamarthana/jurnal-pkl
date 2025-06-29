<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttendanceAdminController;
use App\Http\Controllers\admin\InternshipAdminController;
use App\Http\Controllers\admin\JournalAdminController;
use App\Http\Controllers\Admin\ReportAdminController;
use App\Http\Controllers\Admin\ScheduleAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetController;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\User\AttendanceController;
use App\Http\Controllers\User\JournalController;
use App\Http\Controllers\User\ProfilController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\ScheduleController;
use App\Http\Controllers\VerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use function Pest\Laravel\get;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('index');
    });
    Route::get('verification/login', [LoginController::class, 'index'])->name('login');
    Route::get('verification/signup', [SignupController::class, 'index'])->name('indexSignup');
    Route::post('verification/signup', [SignupController::class, 'store'])->name('signup');
    Route::post('verification/login', [LoginController::class, 'auth'])->name('authLogin');
    Route::get('verification/admin', [LoginController::class, 'admin'])->name('admin');

    Route::get('/forgot-password', [ForgotController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [ForgotController::class, 'email'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [ResetController::class, 'update'])->name('password.update');
});

Route::get('/email/verify', function () {
    return view('verification/auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/beranda');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('indexAdmin');
    Route::get('/admin/absen', [AdminController::class, 'absen'])->name('allAbsen');
    Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('allLaporan');
    Route::get('/admin/schedule', [AdminController::class, 'schedule'])->name('allSchedule');
    Route::get('/admin/pkl', [AdminController::class, 'pkl'])->name('allPkl');
    Route::get('/admin/{id}/absen', [AttendanceAdminController::class, 'index'])->name('userAbsen');
    Route::get('/admin/{id}/laporan', [JournalAdminController::class, 'index'])->name('userLaporan');
    Route::post('/admin/{user}/verifikasi/update', [JournalAdminController::class, 'bulkUpdate'])->name('bulkUpdateVerification');
    Route::get('/admin/{user}/laporan/{id}', [JournalAdminController::class, 'detail'])->name('detailLaporanUser');
    Route::post('/admin/{user}/verif/{id}', [JournalAdminController::class, 'update'])->name('verifLaporanUser');
    Route::post('/admin/{id}/schedule', [ScheduleAdminController::class, 'store'])->name('verifikasiSchedule');
    Route::put('/admin/{id}/schedule', [ScheduleAdminController::class, 'internship'])->name('verifikasiInternship');
    Route::post('/admin/{id}/tugas', [ReportAdminController::class, 'active'])->name('activeTugas');
    Route::get('/admin/{id}/tugas', [ReportAdminController::class, 'index'])->name('indexTugas');
    Route::put('/admin/{id}/tugas', [ReportAdminController::class, 'update'])->name('updateTugas');
    Route::get('/admin/{id}/pkl', [InternshipAdminController::class, 'index'])->name('indexInternship');
    Route::delete('/admin/{id}/pkl', [InternshipAdminController::class, 'delete'])->name('dropInternship');
    Route::put('/admin/{id}/pkl', [InternshipAdminController::class, 'update'])->name('updateInternship');
    Route::post('/admin/pkl', [InternshipAdminController::class, 'store'])->name('createInternship');
});

Route::post('/beranda', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/beranda', [VerificationController::class, 'index']);
    Route::post('/beranda/verify', [VerificationController::class, 'store']);
});

Route::middleware(['auth', 'role:user', 'verified'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('indexProfil');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('editProfil');
    Route::post('/profil/edit', [ProfilController::class, 'store'])->name('updateProfil');

    Route::get('/absen', [AttendanceController::class, 'index'])->name('indexAbsen');
    Route::post('/absen/masuk', [AttendanceController::class, 'masuk'])->name('absenMasuk');
    Route::post('/absen/keluar', [AttendanceController::class, 'keluar'])->name('absenKeluar');
    Route::get('/absen/{user}/print', [AttendanceController::class, 'print'])->name('printAbsen');

    Route::get('/laporan', [JournalController::class, 'index'])->name('indexJournal');
    Route::post('/laporan', [AttendanceController::class, 'store'])->name('addJournal');
    Route::get('/laporan/{id}', [JournalController::class, 'show'])->name('detailJournal');
    Route::get('/laporan/{id}/edit', [JournalController::class, 'detail'])->name('editJournal');
    Route::post('/laporan/{id}/edit', [JournalController::class, 'update'])->name('updateJournal');
    Route::delete('/laporan/{id}/hapus', [JournalController::class, 'drop'])->name('dropJournal');
    Route::get('/laporan/{user}/print', [JournalController::class, 'print'])->name('printJournal');

    Route::post('/jadwal', [ScheduleController::class, 'jadwal'])->name('createJadwal');
    Route::get('/jadwal', [ScheduleController::class, 'index'])->name('indexSchedule');
    Route::put('/jadwal/update', [ScheduleController::class, 'update'])->name('updateSchedule');
    Route::post('/jadwal/static', [ScheduleController::class, 'jadwalStatic'])->name('createStatic');
    Route::put('/jadwal/static/update', [ScheduleController::class, 'updateJadwalStatic'])->name('updateStatic');

    Route::get('/tugas', [ReportController::class, 'index'])->name('indexReport');
    Route::post('/tugas', [ReportController::class, 'pengajuan'])->name('pengajuanReport');
    Route::put('/tugas', [ReportController::class, 'revisi'])->name('revisiReport');
});
