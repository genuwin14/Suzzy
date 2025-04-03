<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'fname' => 'Admin',
            'lname' => 'User',
            'username' => 'admin',
            'password' => Hash::make('keycab2025'), // Default password
        ]);
    }
}
