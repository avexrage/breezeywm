<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function bayarday(){
        return view('layouts.pembayaran');
    }
}
