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
        Schema::create('event_sponsor', function (Blueprint $table) {
            // Define the 'sponsor_id' column before setting it as a foreign key
            $table->unsignedBigInteger('sponsor_id');
            $table->foreign('sponsor_id')->references('sponsor_id')->on('sponsors')->onDelete('cascade');

            // Similarly, ensure 'event_id' is defined before setting it as a foreign key
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade');

            // Define the primary key
            $table->primary(['sponsor_id', 'event_id']);

            // Other columns
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_sponsor');
    }
};
