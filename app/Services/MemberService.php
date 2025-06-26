<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MemberService
{
    public function createAccountMember($credentials)
    {
        return User::create([
            'username' => $credentials['username'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'number' => $credentials['number'],
            'role_id' => 2,
        ]);

    }
}