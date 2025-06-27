<?php

namespace App\Services;

use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function loginUser($credentials)
    {
        if (!Auth::attempt($credentials)) {
            throw new \Exception('Invalid username or password.');
        }

        $user = Auth::user();
        $token = $user->createToken($user->username . '-Authtoken')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}