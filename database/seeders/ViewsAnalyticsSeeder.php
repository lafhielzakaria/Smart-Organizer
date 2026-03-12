<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ViewsAnalytics;
use App\Models\LocalOffer;

class ViewsAnalyticsSeeder extends Seeder
{
    public function run(): void
    {
        $offers = LocalOffer::all();
        
        foreach ($offers as $offer) {
            for ($i = 0; $i < rand(10, 30); $i++) {
                ViewsAnalytics::create([
                    'hoverTime' => fake()->numberBetween(1, 300),
                    'local_offer_id' => $offer->id,
                ]);
            }
        }
    }
}
