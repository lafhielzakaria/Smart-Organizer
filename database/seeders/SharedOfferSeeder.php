<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LocalOffer;
use App\Models\Participation;

class SharedOfferSeeder extends Seeder
{
    public function run(): void
    {
        $lessorRoleId = 3;

        $user1 = User::firstOrCreate(
            ['email' => 'lessor1@test.com'],
            ['name' => 'Lessor One', 'role_id' => $lessorRoleId, 'password' => Hash::make('password'), 'balance' => 500, 'status' => 'active']
        );

        $user2 = User::firstOrCreate(
            ['email' => 'lessor2@test.com'],
            ['name' => 'Lessor Two', 'role_id' => $lessorRoleId, 'password' => Hash::make('password'), 'balance' => 500, 'status' => 'active']
        );

        $offer = LocalOffer::where('status', 'available')->first();

        foreach ([$user1, $user2] as $user) {
            Participation::firstOrCreate(
                ['user_id' => $user->id, 'local_offer_id' => $offer->id],
                ['joinedAt' => now(), 'sharePrice' => $offer->totalPrice / 2, 'leftAt' => null]
            );
        }
    }
}
