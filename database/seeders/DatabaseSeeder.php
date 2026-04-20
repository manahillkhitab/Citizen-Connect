<?php

namespace Database\Seeders;

use App\Models\User;
// Import Hash to secure the password
use Illuminate\Support\Facades\Hash; 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Account
        if (!User::where('cnic', '11111-1111111-1')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'cnic' => '11111-1111111-1',
                'phone' => '0300-0000000',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]);
            echo "Admin Account Created!\n";
        }

        // 2. Department Account
        if (!User::where('cnic', '22222-2222222-2')->exists()) {
            User::create([
                'name' => 'Police Department',
                'cnic' => '22222-2222222-2',
                'phone' => '0311-1111111',
                'role' => 'department',
                'password' => Hash::make('dept123'),
            ]);
            echo "Department Account Created!\n";
        }

        // 3. Citizen (User) Account
        if (!User::where('cnic', '77777-7777777-7')->exists()) {
            User::create([
                'name' => 'Test Citizen',
                'cnic' => '77777-7777777-7',
                'phone' => '0321-1111111',
                'role' => 'citizen',
                'password' => Hash::make('user123'),
            ]);
            echo "Citizen Account Created!\n";
        }
    }
}