<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginApiController extends Controller
{
    public function login(Request $request)
    {
        $appType = strtolower($request->header('X-App-Type', 'unknown'));

        if (!in_array($appType, ['client', 'agent'])) {
            return response()->json(['status' => false, 'message' => 'Invalid X-App-Type'], 400);
        }

        $request->validate([
            'phone' => 'required|numeric|digits:10',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'device_id' => 'required|string|max:255',
            'device_model' => 'required|string|max:255',
            'device_name' => 'required|string|max:255',
        ]);

        if ($appType === 'client') {
            $userModel = Client::class;
        } else {
            $userModel = Agent::class;
        }

        $entity = $userModel::firstOrCreate(
            ['phone' => $request->phone],
            [
                'phone' => $request->phone ?? null,
            ]
        );

        $user = $entity->user; // fetch corresponding user

        UserDevice::updateOrCreate(
            [
                'user_id' => $user->id,
                'device_id' => $request->device_id,
            ],
            [
                'device_model' => $request->device_model,
                'device_name' => $request->device_name,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'ip_address' => $request->ip(),
                'last_login_at' => now(),
            ]
        );

        $otpCode = random_int(100000, 999999);
        UserOtp::create([
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'expires_at' => now()->addMinutes(5),
            'type' => 'login',
        ]);

        $message = "{$otpCode} is your verification code for Finova.";
        SMSHelper::sendSMS($message, $request->phone);

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully',
            'expires_at' => now()->addMinutes(5)->toDateTimeString(),
            'user_id' => $user->id,
            'type' => $appType,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $appType = strtolower($request->header('X-App-Type', 'unknown'));

        if (!in_array($appType, ['client', 'agent'])) {
            return response()->json(['status' => false, 'message' => 'Invalid X-App-Type'], 400);
        }

        $request->validate([
            'phone' => 'required|numeric|digits:10',
            'otp' => 'required|numeric|digits:6',
        ]);

        $userModel = $appType === 'client' ? Client::class : Agent::class;
        $entity = $userModel::where('phone', $request->phone)->first();

        if (!$entity) {
            return response()->json(['status' => false, 'message' => ucfirst($appType) . ' not found'], 404);
        }

        $user = $entity->user;

        $otpRecord = UserOtp::where('user_id', $user->id)
            ->where('otp_code', $request->otp)
            ->where('expires_at', '>=', now())
            ->latest()
            ->first();

        if (!$otpRecord) {
            return response()->json(['status' => false, 'message' => 'Invalid or expired OTP'], 422);
        }

        $otpRecord->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        $token = $user->createToken($appType.'_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'OTP verified successfully',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'type' => $appType
            ]
        ]);
    }

}
