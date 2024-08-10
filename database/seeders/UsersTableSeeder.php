<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create a new user instance
        $user = new User();

        // Set the user attributes
        $user->name = 'Test';
        $user->email = 'test@example.com';

        // Hash the password using Laravel's Hash facade
        $user->password = Hash::make('Testas');

        // Save the user into the database
        $user->save();
    }
}
