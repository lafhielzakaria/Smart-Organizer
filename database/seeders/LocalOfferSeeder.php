<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LocalOffer;
use App\Models\Local;

class LocalOfferSeeder extends Seeder
{
    public function run(): void
    {
        $locals = Local::all();
        
        foreach ($locals as $local) {
            for ($i = 0; $i < rand(2, 5); $i++) {
                LocalOffer::create([
                    'startTime' => fake()->dateTimeBetween('now', '+1 month'),
                    'endTime' => fake()->dateTimeBetween('+1 month', '+2 months'),
                    'pricePerPerson' => fake()->numberBetween(20, 150),
                    'maxParticipants' => fake()->numberBetween(10, 50),
                    'status' => fake()->randomElement(['available', 'completed', 'cancelled']),
                    'local_id' => $local->id,
                ]);
            }
        }
    }
}
