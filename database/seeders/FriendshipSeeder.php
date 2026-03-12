<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Friendship;
use App\Models\User;

class FriendshipSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        for ($i = 0; $i < 20; $i++) {
            Friendship::create([
                'sender_id' => $users->random()->id,
                'receiver_id' => $users->random()->id,
                'status' => fake()->randomElement(['pending', 'accepted', 'rejected']),
            ]);
        }
    }
}
