<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        User::create([
            'name' => 'Admin',
            'role_id' => 1,
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'balance' => 0,
            'status' => 'active',
        ]);

        User::factory(29)->create();

        $this->call([
            FriendshipSeeder::class,
            LocalSeeder::class,
            LocalOfferSeeder::class,
            ChatRoomSeeder::class,
            ParticipationSeeder::class,
            MessageSeeder::class,
            ViewsAnalyticsSeeder::class,
        ]);
    }
}
