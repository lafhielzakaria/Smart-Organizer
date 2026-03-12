<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatRoom;
use App\Models\LocalOffer;

class ChatRoomSeeder extends Seeder
{
    public function run(): void
    {
        $offers = LocalOffer::all();
        
        foreach ($offers as $offer) {
            ChatRoom::create([
                'local_offer_id' => $offer->id,
            ]);
        }
    }
}
