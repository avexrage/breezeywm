<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PendaftaranController;
use App\Models\Pendaftaran;
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
Route::group(['middleware' => ['auth.admin']], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    //Pendaftaran Day
    Route::get('/data-pendaftaran/day-care', [AdminController::class, 'showPendaftaranDay'])->name('datapdftrday');
    Route::get('/data-pendaftaran/day-care/cetak', [AdminController::class, 'showCetakPdftrDay'])->name('showcetakpdftrday');
    Route::get('/data-pendaftaran/day-care/cetakdata', [AdminController::class, 'cetakPendaftaranDay'])->name('cetakpdftrday');
    Route::post('/data-pendaftaran/day-care/update', [AdminController::class, 'updatePendaftaranDay'])->name('updatepdftrday');

    //Pendaftaran Grha
    Route::get('/data-pendaftaran/grha-wredha-mulya', [AdminController::class, 'showPendaftaranGrha'])->name('datapdftrgrha');
    Route::get('/data-pendaftaran/grha-wredha-mulya/cetak', [AdminController::class, 'showCetakPdftrGrha'])->name('showcetakpdftrgrha');
    Route::get('/data-pendaftaran/grha-wredha-mulya/cetakdata', [AdminController::class, 'cetakPendaftaranGrha'])->name('cetakpdftrgrha');
    Route::post('/data-pendaftaran/grha-wredha-mulya/update', [AdminController::class, 'updatePendaftaranGrha'])->name('updatepdftrgrha');

    //Pembayaran Day
    Route::get('/data-pembayaran/day-care', [AdminController::class, 'showPembayaranDay'])->name('datapbyrday');
    Route::get('/data-pembayaran/day-care/cetak', [AdminController::class, 'showCetakPbyrDay'])->name('showcetakpbyrday');
    Route::get('/data-pembayaran/day-care/cetakdata', [AdminController::class, 'cetakPembayaranDay'])->name('cetakpbyrday');
    Route::post('/data-pembayaran/day-care/update', [AdminController::class, 'updatePembayaranDay'])->name('updatepbyrday');

    //Pembayaran Grha
    Route::get('/data-pembayaran/grha-wredha-mulya', [AdminController::class, 'showPembayaranGrha'])->name('datapbyrgrha');
    Route::get('/data-pembayaran/grha-wredha-mulya/cetak', [AdminController::class, 'showCetakPdftrGrha'])->name('showcetakpbyrgrha');
    Route::get('/data-pembayaran/grha-wredha-mulya/cetakdata', [AdminController::class, 'cetakPembayaranGrha'])->name('cetakpbyrgrha');
    Route::post('/data-pembayaran/grha-wredha-mulya/update', [AdminController::class, 'updatePembayaranGrha'])->name('updatepbyrgrha');

    //Peserta Day
    Route::get('/data-peserta/day-care', [AdminController::class, 'showPesertaDay'])->name('datapsrtday');
    Route::get('/data-peserta/day-care/cetak', [AdminController::class, 'showCetakPsrtDay'])->name('showcetakpsrtday');
    Route::get('/data-peserta/day-care/cetakdata', [AdminController::class, 'cetakPesertaDay'])->name('cetakpsrtday');
    Route::post('/data-peserta/day-care/update', [AdminController::class, 'updatePesertaDay'])->name('updatepsrtday');

    //Peserta Grha
    Route::get('/data-peserta/grha-wredha-mulya', [AdminController::class, 'showPesertaGrha'])->name('datapsrtgrha');
    Route::get('/data-peserta/grha-wredha-mulya/cetak', [AdminController::class, 'showCetakPsrtGrha'])->name('showcetakpsrtgrha');
    Route::get('/data-peserta/grha-wredha-mulya/cetakdata', [AdminController::class, 'cetakPesertaGrha'])->name('cetakpsrtgrha');
    Route::post('/data-peserta/grha-wredha-mulya/update', [AdminController::class, 'updatePesertaGrha'])->name('updatepsrtgrha');
});

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('adminlogin');
Route::post('/admin/login', [AdminController::class, 'login'])->name('adminloginpost');
Route::post('/admin/logout', [AdminController::class, 'adminLogout'])->name('adminlogout');



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


//DAY CARE
Route::get('/daftar', [PendaftaranController::class, 'showDaftar'])->name('showdaftar');
Route::post('/daftar/daycare', [PendaftaranController::class, 'daftar'])->name('daftarday');

//GRHA WREDHA
Route::get('/daftar/grha', [PendaftaranController::class, 'showDaftar2'])->name('showdaftar2');
Route::post('/daftar/grha', [PendaftaranController::class, 'daftar2'])->name('daftargrha');
Route::get('/lanjutkan-pembayaran/{id}', [PendaftaranController::class, 'lanjutkanPembayaran'])->name('lanjutkanPembayaran');
Route::get('/batalkan-pendaftaran/{id}', [PendaftaranController::class, 'batalkanPendaftaran'])->name('batalkanPendaftaran');

Route::get('/cancel', [PendaftaranController::class, 'cancelRegistration'])->name('cancel');

//Pembayaran
Route::get('/tagihan-pembayaran', [PembayaranController::class, 'bayar'])->name('bayar')->middleware(['auth', 'verified']);
Route::post('/proses-pembayaran/{id}', [PembayaranController::class, 'pilihMetode'])->name('pilihmetode');
Route::get('/cetak-bukti-pendaftaran/{id}', [PembayaranController::class, 'cetakBuktiPendaftaran'])->name('cetakBuktiPendaftaran');
Route::post('/upload-bukti-pembayaran/{id}', [PembayaranController::class, 'uploadBuktiPembayaran'])->name('uploadBuktiPembayaran');
Route::get('/cetak-pdf/{id}', [PembayaranController::class, 'cetakBuktiPendaftaran'])->name('cetak-pdf');

//Riwayat
Route::get('/riwayat-pendaftaran', [ProfileController::class, 'showRiwayat'])->name('riwayat');