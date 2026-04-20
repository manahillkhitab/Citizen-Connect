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
        // Check if Admin exists to avoid duplicates
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            User::create([
                'name' => 'Super Admin',
                'cnic' => '11111-1111111-1', // Special CNIC for Admin
                'phone' => '0300-0000000',   // Special Phone for Admin
                'role' => 'admin',           // This is the important part!
                'password' => Hash::make('admin123'), // Password is 'admin123'
            ]);
            
            echo "Admin Account Created Successfully!\n";
        } else {
            echo "Admin already exists.\n";
        }
    }
}