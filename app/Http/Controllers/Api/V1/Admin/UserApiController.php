<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|min:10'
        ]);

        $otp = rand(1111, 9999);

        $user = User::updateOrCreate([
            'phone' => $request->phone
        ],[
            'name' => '',
            'email' => '',
            'otp' => $otp,
            'password' => ''
        ]);

        return response()->json([
            'success' => true,
            'phone' => $request->phone,
            'otp' => $user->otp,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required'
        ]);

        $user = User::where("phone", $request->phone)->where("otp", $request->otp)->first();

        if (!$user) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'otp' => [
                        'Invalid credentials'
                    ],
                ]
            ], 422);
        }

        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'access_token' => $authToken,
        ]);
    }

    public function userGet(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $user = User::where("phone", $request->phone)->first();

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }
}
