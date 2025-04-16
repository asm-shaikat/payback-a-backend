<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginOtpController extends Controller
{
    // POST /api/send-otp
    public function sendOtp(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => 'Invalid or missing email.'], 422);
        }

        $email = $data['email'];
        $otp = rand(100000, 999999);

        EmailOtp::updateOrCreate(
            ['email' => $email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5)
            ]
        );

        // Send OTP via raw email
        Mail::raw("Your OTP is: $otp", function ($message) use ($email) {
            $message->to($email)
                ->subject('Your OTP Login Code');
        });

        return response()->json(['message' => 'OTP sent to your email address.']);
    }

    // POST /api/verify-otp
    public function verifyOtp(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (
            !isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ||
            !isset($data['otp']) || !is_string($data['otp'])
        ) {
            return response()->json(['message' => 'Invalid email or OTP.'], 422);
        }

        $email = $data['email'];
        $otp = $data['otp'];

        $otpRecord = EmailOtp::where('email', $email)
            ->where('otp', $otp)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 401);
        }

        // Check if user exists or create
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => explode('@', $email)[0],
                'password' => bcrypt(Str::random(10))
            ]
        );

        $token = $user->createToken('api-token')->plainTextToken;

        $otpRecord->delete();

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token
        ]);
    }
}
