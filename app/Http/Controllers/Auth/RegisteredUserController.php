<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RCell;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $rCells = RCell::all();
        return view('auth.register', compact('rCells'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
<<<<<<< HEAD
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
=======


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
>>>>>>> 9ef8c57 (try new for post)
            'phone' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:student,faculty_member'],
            'student_id' => ['nullable', 'string', 'max:255', 'unique:' . User::class],
            'r_cell_id' => ['nullable', 'exists:r_cells,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
<<<<<<< HEAD
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'student_id' => $request->student_id,
            'r_cell_id' => $request->r_cell_id,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        return redirect(route('login'))->with('status', 'Registration successful! Please wait for admin approval.');
=======
            'email' => array_merge(
                [
                    'required',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    Rule::unique(User::class, 'email'),
                ],
                $request->role === 'student'
                    ? ['regex:/^[A-Za-z0-9._%+-]+@student\.green\.edu\.bd$/']
                    : ($request->role === 'faculty_member'
                        ? ['regex:/^[A-Za-z0-9._%+-]+@megabuybd\.com$/']
                        : [])
            ),
        ]);




        $otp = rand(100000, 999999);
        $user = $request->only('name', 'email', 'phone', 'role', 'student_id', 'r_cell_id', 'password');
        $user['password'] = Hash::make($request->password);

        Session::put('otp', $otp);
        Session::put('otp_expires_at', now()->addMinutes(2));
        Session::put('user_data', $user);
        Session::put('registration_data_expires_at', now()->addMinutes(10));


        Mail::to($request->email)->send(new SendOtpMail($otp));

        return redirect()->route('otp.verification')->with('status', 'An OTP has been sent to your email address.');
>>>>>>> 9ef8c57 (try new for post)
    }
}
