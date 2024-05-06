<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;  // Import the Log facade

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        Log::info('Starting email verification for user ID: ' . $request->user()->id);

        if ($request->user()->hasVerifiedEmail()) {
            Log::info('Email already verified for user ID: ' . $request->user()->id);
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
            Log::info('Email marked as verified for user ID: ' . $request->user()->id);
        } else {
            Log::warning('Failed to verify email for user ID: ' . $request->user()->id);
        }

        return redirect('/admin')->with('verified', 'Email Anda telah berhasil diverifikasi. Silahkan Login untuk melanjutkan.');
    }
}
