<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Participation;
use App\Models\LocalOffer;
use App\Models\User;

class ParticipationSeeder extends Seeder
{
    public function run(): void
    {
        $offers = LocalOffer::where('status', 'available')->get();
        $users = User::all();
        
        foreach ($offers as $offer) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                Participation::create([
                    'joinedAt' => fake()->dateTimeBetween('-1 month', 'now'),
                    'user_id' => $users->random()->id,
                    'sharePrice' => $offer->totalPrice,
                    'leftAt' => fake()->boolean(30) ? fake()->dateTimeBetween('now', '+1 week') : null,
                    'local_offer_id' => $offer->id,
                ]);
            }
        }
    }
}
