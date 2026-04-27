<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Mail\OtpMail;
use App\Models\LoginOtp;
use App\Models\TrustedDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials, false)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid email or password.'], 401);
            }
        }

        $user = Auth::user();

        // Log back out — must pass OTP or device check first
        Auth::logout();

        // ── Check for a trusted-device cookie ──────────────────────────
        $deviceToken = $request->cookie('trusted_device');

        if ($deviceToken) {
            $trusted = TrustedDevice::where('user_id', $user->id)
                ->where('token', $deviceToken)
                ->first();

            if ($trusted) {
                // Device is recognised — log straight in, refresh last-used
                $trusted->update(['last_used_at' => now()]);

                Auth::login($user);
                $request->session()->regenerate();

                if ($request->expectsJson()) {
                    return response()->json(['redirect' => route('dashboard')]);
                }
                return redirect()->route('dashboard');
            }
        }

        // ── New/unknown device — generate OTP ─────────────────────────
        LoginOtp::where('user_id', $user->id)->delete();

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        LoginOtp::create([
            'user_id'    => $user->id,
            'code'       => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new OtpMail($code, $user->first_name));

        // Keep the user's ID in session so the OTP screen knows who to verify
        session(['otp_user_id' => $user->id]);

        if ($request->expectsJson()) {
            return response()->json(['redirect' => route('otp.show')]);
        }

        return redirect()->route('otp.show');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
