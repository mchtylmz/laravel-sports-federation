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
            'name' => 'superadmin',
            'username' => 'superadmin',
            'password' => Hash::make('superadmin')
        ]);
        User::create([
            'role' => 'admin',
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('admin')
        ]);
        $manager = User::create([
            'role' => 'manager',
            'name' => 'manager',
            'username' => 'manager',
            'password' => Hash::make('manager')
        ]);
        $manager->createMeta([
            'places' => json_encode([
                'Stadyum 1',
                'Stadyum 2',
                'Stadyum 3',
                'Stadyum 4',
            ])
        ]);

        settings()->set([
            'site_title' => 'Spor',
            'site_logo'  => 'uploads/logo.png',
            'site_favicon'  => 'uploads/logo.png',
        ]);
        // Save all settings
        settings()->save();
    }
}
