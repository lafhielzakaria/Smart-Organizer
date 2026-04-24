<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Local;
use App\Models\User;

class LocalSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = User::where('role_id', 2)->get();
        $cities = ['Casablanca', 'Rabat', 'Marrakech', 'Fes', 'Tangier', 'Agadir', 'Meknes', 'Oujda', 'Kenitra', 'Tetouan'];
        $images = [
            'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800',
            'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=800',
            'https://images.unsplash.com/photo-1514933651103-005eec06c04b?w=800',
            'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800',
            'https://images.unsplash.com/photo-1559339352-11d035aa65de?w=800',
            'https://images.unsplash.com/photo-1571997478779-2adcbbe9ab2f?w=800',
            'https://images.unsplash.com/photo-1578474846511-04ba529f0b88?w=800',
            'https://images.unsplash.com/photo-1470337458703-46ad1756a187?w=800',
        ];
        
        foreach ($tenants as $tenant) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                Local::create([
                    'creator_id' => $tenant->id,
                    'name' => fake()->company() . ' ' . fake()->randomElement(['Restaurant', 'Café', 'Club', 'Bar']),
                    'type' => fake()->randomElement(['restaurant', 'café', 'club', 'bar', 'lounge']),
                    'capacity' => fake()->numberBetween(20, 200),
                    'city' => fake()->randomElement($cities),
                    'andreas' => fake()->streetAddress(),
                    'description' => fake()->sentence(12),
                    'price' => fake()->numberBetween(50, 500),
                    'status' => fake()->randomElement(['active', 'blocked']),
                    'image' => fake()->randomElement($images),
                ]);
            }
        }
    }
}
