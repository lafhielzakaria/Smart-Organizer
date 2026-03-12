<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\ChatRoom;
use App\Models\User;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $chatRooms = ChatRoom::all();
        $users = User::all();
        
        foreach ($chatRooms as $chatRoom) {
            for ($i = 0; $i < rand(5, 15); $i++) {
                Message::create([
                    'content' => fake()->sentence(rand(5, 20)),
                    'sender_id' => $users->random()->id,
                    'chat_room_id' => $chatRoom->id,
                ]);
            }
        }
    }
}
