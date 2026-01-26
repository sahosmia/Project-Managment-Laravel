<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    /**
     * Show the OTP verification form.
     */
    public function create()
    {
        if (!Session::has('user_data') || !Session::has('otp')) {
            return redirect()->route('register')->withErrors(['email' => 'Registration session expired. Please register again.']);
        }
        return view('auth.verify-otp');
    }

    /**
     * Verify the OTP.
     */
    public function store(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        if (!Session::has('user_data') || !Session::has('otp')) {
            return redirect()->route('register')->withErrors(['email' => 'Registration session expired. Please register again.']);
        }

        $this->ensureIsNotRateLimited($request);

        if (Session::get('registration_data_expires_at') < now()) {
            Session::forget(['otp', 'otp_expires_at', 'user_data', 'registration_data_expires_at']);
            return redirect()->route('register')->withErrors(['email' => 'Registration session expired. Please register again.']);
        }

        if (Session::get('otp_expires_at') < now()) {
            RateLimiter::hit($this->throttleKey($request));
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        if ($request->otp != Session::get('otp')) {
            RateLimiter::hit($this->throttleKey($request));
            return back()->withErrors(['otp' => 'The provided OTP is incorrect.']);
        }

        $user = User::create(Session::get('user_data'));

        event(new Registered($user));

        Auth::login($user);

        Session::forget(['otp', 'otp_expires_at', 'user_data', 'registration_data_expires_at']);

        return redirect()->route('dashboard')->with('status', 'Registration successful!');
    }

    /**
     * Resend the OTP.
     */
    public function resend()
    {
        if (!Session::has('user_data')) {
            return redirect()->route('register')->withErrors(['email' => 'Registration session expired. Please register again.']);
        }

        $otp = rand(100000, 999999);
        Session::put('otp', $otp);
        Session::put('otp_expires_at', now()->addMinutes(2));

        Mail::to(Session::get('user_data.email'))->send(new SendOtpMail($otp));

        return back()->with('status', 'A new OTP has been sent to your email address.');
    }

    protected function ensureIsNotRateLimited(Request $request)
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 3)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            throw ValidationException::withMessages([
                'otp' => "Too many verification attempts. Please try again in {$seconds} seconds.",
            ]);
        }
    }

    protected function throttleKey(Request $request)
    {
        return 'otp-verification|' . Session::get('user_data.email');
    }
}
