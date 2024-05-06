<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;


class VerifyController extends Controller
{
    //
    public function handleVerification(Request $request)
{
    if (! $request->hasValidSignature()) {
        return redirect(route('login'))->withErrors(['email' => 'Invalid verification link.']);
    }

    $user = User::where('id', $request->route('id'))
               ->where('hash', sha1($request->route('hash')))
               ->first();

    if (! $user) {
        return redirect(route('login'))->withErrors(['email' => 'Could not verify your email address.']);
    }

    $user->email_verified_at = Carbon::now();
    $user->save();

    return redirect(route('login'))->with('status', 'Your email address has been verified!');
}

}
