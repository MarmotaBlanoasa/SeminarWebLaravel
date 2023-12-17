<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpeakersTable extends Migration
{
    public function up()
    {
        Schema::create('speakers', function (Blueprint $table) {
            $table->id('speaker_id');
            $table->string('nume');
            $table->string('prenume');
            $table->string('email', 320);
            $table->string('telefon', 15);
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('speakers');
    }
}
