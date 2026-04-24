<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\User;

Schedule::call(function () {
    User::where('isMember', true)->each(function ($user) {
        $user->update(['balance' => $user->balance - 1000]);
    });
})->monthly();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
