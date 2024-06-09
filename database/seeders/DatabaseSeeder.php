<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'role' => 'superadmin',
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin')
        ]);


        settings()->set([
            'site_title' => 'Spor',
            'site_logo'  => 'uploads/logo.png'
        ]);
        // Save all settings
        settings()->save();
    }
}
