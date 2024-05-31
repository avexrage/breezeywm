<?php

use App\Http\Controllers\AdminController as ControllersAdminController;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


//ADMIN
// Route::group(['middleware' => ['auth.admin']], function () {
    Route::get('/admin', function () {
        return view('admin.index');
    });
// });

Route::get('/admin/login', [ControllersAdminController::class, 'showLoginForm']);
Route::post('/admin/login', [ControllersAdminController::class, 'login'])->name('admin.login');


//LOGIN LOGOUT
Route::get('/auth', [SesiController::class, 'showLoginForm'])->name('login');
Route::post('/auth/login', [SesiController::class, 'actionLogin'])->name('actionlogin');
Route::get('/auth/logout', [SesiController::class, 'actionLogout'])->name('actionlogout');

//REGISTER
Route::get('/auth/register', [SesiController::class, 'showRegisterForm'])->name('register');
Route::post('/auth/register/form', [SesiController::class, 'actionRegister'])->name('actionregister');

//FORGOT PASSWORD
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

//Email Verification
Route::get('/email', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/')->with('success', 'Selamat Anda Berhasil Login');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//HOME
Route::get('/', [HomeController::class, 'landingPage'])->name('home');

//NAVBAR PENDAFTARAN
Route::get('/pilihan-program', function (){
    return view('layouts.pilihanprogram');
})->name('daftar');

//cekview
Route::get('/test', function (){
    return view('test');
});

//FORM PENDAFTARAN
Route::get('/form', [PendaftaranController::class, 'create'])->name('tampilform')->middleware(['auth', 'verified']);        
Route::post('/form', [PendaftaranController::class, 'store'])->name('simpanform');

Route::get('/daftar', [PendaftaranController::class, 'showDaftar'])->name('showDaftar')->middleware('check.registration');
Route::post('/daftar/daycare', [PendaftaranController::class, 'daftar'])->name('daftarday');

Route::get('/daftar/grha', [PendaftaranController::class, 'showDaftar2'])->name('showDaftar2');
Route::post('/daftar/grha/video', [PendaftaranController::class, 'daftar2'])->name('daftargrha');

Route::get('/cancel', [PendaftaranController::class, 'cancelRegistration'])->name('cancel');

//Pembayaran
Route::get('/tagihan-pembayaran', [PembayaranController::class, 'bayarday'])->name('bayarday')->middleware(['auth', 'verified']);
Route::get('/cetak-bukti-pendaftaran/{id}', [PembayaranController::class, 'cetakBuktiPendaftaran'])->name('cetakBuktiPendaftaran');
Route::post('/upload-bukti-pembayaran/{id}', [PembayaranController::class, 'uploadBuktiPembayaran'])->name('uploadBuktiPembayaran');
Route::get('/cetak-pdf/{id}', [PembayaranController::class, 'cetakBuktiPendaftaran'])->name('cetak-pdf');

//Riwayat
Route::get('/riwayat-pendaftaran', [ProfileController::class, 'showRiwayat'])->name('riwayat');