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
                ]);
            }
        }
    }
}
