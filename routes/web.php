<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\HomeController;
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
Route::get('/admin', function () {
    return view('admin.index');
});

//LOGIN LOGOUT
Route::get('/sesi', [SesiController::class, 'showLoginForm'])->name('login');
Route::post('/sesi/login', [SesiController::class, 'actionLogin'])->name('actionlogin');
Route::get('/sesi/logout', [SesiController::class, 'actionLogout'])->name('actionlogout');

//REGISTER
Route::get('/sesi/register', [SesiController::class, 'showRegisterForm'])->name('register');
Route::post('/sesi/register/form', [SesiController::class, 'actionRegister'])->name('actionregister');

//Email Verification
Route::get('/email', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/pilihan-program');
})->middleware(['auth', 'signed'])->name('verification.verify');

//HOME
Route::get('/', [HomeController::class, 'landingPage'])->name('home');

//PENDAFTARAN
Route::get('/pilihan-program', function (){
    return view('layouts.pilihanprogram');
})->name('daftar');

//FORM
Route::get('/form', [PendaftaranController::class, 'create'])->name('layouts.create')->middleware(['IsLogin']);
Route::post('/form', [PendaftaranController::class, 'store'])->name('layouts.store');

