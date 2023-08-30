<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'user_admin@gmail.com',
            'password' => Hash::make('user_admin'), // You can change this password
            'date_of_birth' => '1999-02-14',
            'avatar' => null, // Nullable avatar
            'role' => 'admin', // Assuming you have a 'role' field in the User model
        ]);
    }
}
