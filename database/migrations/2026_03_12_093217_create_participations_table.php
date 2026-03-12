<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participations', function (Blueprint $table) {
            $table->id();
            $table->dateTime('joinedAt');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('sharePrice', 10, 2);
            $table->dateTime('leftAt')->nullable();
            $table->foreignId('local_offer_id')->constrained('local_offers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participations');
    }
};
