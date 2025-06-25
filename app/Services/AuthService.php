<?php

namespace App\Services;

use App\Models\User;
use Hash;

class AuthService
{
    public function loginUser($credentials)
    {
        $user = User::query()->where('username', $credentials['username'])->first();

        if ($user && !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                "message" => "Wrong username or password"
            ], 401);
        }

        $token = $user->createToken($user->username . '-Authtoken')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}