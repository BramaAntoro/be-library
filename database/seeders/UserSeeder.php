<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::query()->where('name', '=', 'admin')->first();
        User::query()->create([
            'username' => 'example',
            'email' => 'example@gmail.com',
            'password' => Hash::make('example123'),
            'number' => 123456789,
            'role_id' => $roleAdmin->id
        ]);
    }
}
