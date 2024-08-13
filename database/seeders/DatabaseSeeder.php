<?php

namespace Database\Seeders;

use App\Enums\EventTypeEnum;
use App\Models\Club;
use App\Models\Event;
use App\Models\Federation;
use App\Models\People;
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
        $admin = User::create([
            'role' => 'admin',
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('admin')
        ]);
        User::create([
            'role' => 'calendar',
            'name' => 'calendar',
            'username' => 'calendar',
            'password' => Hash::make('calendar')
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

        $federation = Federation::create([
            'name' => 'Futbol Federasyonu'
        ]);
        $admin->setMeta([
            'federation_id' => $federation->id
        ]);

        People::create([
            'federation_id' => $federation->id,
            'type' => 'player',
            'name' => 'Oyuncu 1',
            'surname' => 'Oyuncu'
        ]);

        People::create([
            'federation_id' => $federation->id,
            'type' => 'referee',
            'name' => 'Hakem 1',
            'surname' => 'Hakem'
        ]);

        People::create([
            'federation_id' => $federation->id,
            'type' => 'coach',
            'name' => 'Antrenör 1',
            'surname' => 'Antrenör'
        ]);

        Club::create([
            'federation_id' => $federation->id,
            'name' => 'Futbol Kulübü',
            'user_name' => 'Kulüb yönetici ismi'
        ]);

        Event::insert([
            [
                'user_id' => $manager->id,
                'type' => EventTypeEnum::event,
                'title' => 'Saha tanıtım etkinliği',
                'start_date' => now()->subHours(2),
                'end_date' => now()->subHours(1),
            ],
            [
                'user_id' => $admin->id,
                'type' => EventTypeEnum::event,
                'title' => 'Futbol etkinliği',
                'start_date' => now()->subDays(2),
                'end_date' => now()->subDays(2),
            ],
            [
                'user_id' => $admin->id,
                'type' => EventTypeEnum::federation_date,
                'title' => 'Genel Kurul Tarihi',
                'start_date' => now()->addDay(),
                'end_date' => now()->addDay(),
            ],
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
