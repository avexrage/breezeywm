<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class SesiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('sesi.login');
    }

    public function showRegisterForm()
    {
        return view('sesi.register');
    }

    public function actionLogin(Request $request)
    {
        Session::flash('email', $request->email);
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required'
            ],[
                'email.required' => 'Email wajib diisi!',
                'password.required' => 'Password wajib diisi!',
                'captcha.required' => 'Jawaban Captcha wajib diisi!'
            ]);

        if($request->captcha != session('captcha')){
            return back()->withErrors(['captcha' => 'Jawaban Anda Salah'])->withInput();
        }
        
        $credentials =$request->only('email', 'password');

        if(Auth::attempt($credentials)){
            //otentikasi sukses
            return redirect('/')->with('success', Auth::user()->name . 'Selamat Anda Berhasil Login');
        }else{
            //otentikasi gagal
            return redirect()->back()->withErrors(['Email dan Password yang dimasukkan tidak valid']);
        }
    }

    public function actionRegister(Request $request)
    {
        Session::flash('nama', $request->nama);
        Session::flash('ktp', $request->ktp);
        Session::flash('email', $request->email);
        Session::flash('no_hp', $request->nohp);
        Session::flash('alamat', $request->alamat);
        Session::flash('pekerjaan', $request->pekerjaan);
        
        $request->validate([
            'nama' => 'required|string',
            'ktp' => 'required|string|unique:user,ktp|size:16',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6',
            'nohp' => 'required|string|max:13',
            'alamat' => 'required|string',
            'pekerjaan' => 'required|string'
            ],[
                'nama.required' => 'Nama Lengkap wajib diisi!',
                'ktp.required' => 'Nomor KTP wajib diisi!',
                'ktp.unique' => 'Nomor KTP sudah terdaftar',
                'ktp.size' => 'Nomor KTP harus tepat 16 digit.',
                'email.required' => 'Email wajib diisi!',
                'email.email' => 'Silahkan masukkan email yang valid',
                'email.unique' => 'Email sudah terdaftar, gunakan email lain',
                'password.required' => 'Password wajib diisi!',
                'password.min' => 'Password minimal 6 karakter!',
                'nohp.required' => 'Nomor HP wajib diisi!',
                'nohp.max' => 'Nomor HP maksimal 13 digit',
                'alamat.required' => 'Alamat wajib diisi!',
                'pekerjaan.required' => 'Pekerjaan wajib diisi!'
            ]);
        
        $dataUser =[
            'nama' => $request->nama,
            'ktp' => $request->ktp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->nohp,
            'alamat' => $request->alamat,
            'pekerjaan' => $request->pekerjaan
        ];
        $user = User::create($dataUser);
        // $user->sendEmailVerificationNotification();
        event(new Registered($user));
        Auth::login($user);
        
        return redirect('/email');
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }

}