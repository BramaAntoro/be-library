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

    public function getAllMembers()
    {
        return User::query()->where('role_id', '=', 2)->get();
    }

    public function searchMember($keyword)
    {   
        return User::query()
            ->where('role_id', '=', 2)
            ->where('username', 'like', "%$keyword%")->get();
    }

    public function UpdateMember($id, array $data)
    {
        $member = User::query()->findOrFail($id);

        $member->update($data);

        return $member;
    }

    public function deleteMember($id)
    {
        $user = User::query()->findOrFail($id);

        $user->delete();

        return true;
    }


}