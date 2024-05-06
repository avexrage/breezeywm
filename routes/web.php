<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\IsLogin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\VerifyController;

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

Auth::routes(['verify' => true]);

Route::get('email/verify/{id}/{hash}', [VerifyController::class, 'handleVerification'])->name('verification.verify');

//LOGIN
Route::get('/sesi', [SesiController::class, 'showLoginForm'])->name('login');
Route::post('/sesi/login', [SesiController::class, 'actionLogin'])->name('actionlogin');
Route::get('/sesi/logout', [SesiController::class, 'actionLogout'])->name('actionlogout');

//REGISTER
Route::get('/sesi/register', [SesiController::class, 'showRegisterForm'])->name('register');
Route::post('/sesi/register/form', [SesiController::class, 'actionRegister'])->name('actionregister');

//HOME
Route::get('/', [HomeController::class, 'landingPage'])->name('home');

//PENDAFTARAN
Route::get('/pilihan-program', function (){
    return view('layouts.pilihanprogram');
})->name('daftar');

//FORM
Route::get('/form', [PendaftaranController::class, 'create'])->name('layouts.create')->middleware('IsLogin');
Route::post('/form', [PendaftaranController::class, 'store'])->name('layouts.store');



