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
        Schema::create('schedule', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->foreignId('event_id')->constrained('events');
            $table->string('session_name');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('description')->nullable();
            $table->foreignId('speaker_id')->constrained('speakers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule');
    }
};
