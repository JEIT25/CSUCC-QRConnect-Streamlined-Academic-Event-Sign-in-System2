<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendee_id')->constrained('users')->onDelete('cascade');  // Foreign key to users table
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');   // Foreign key to events table
            $table->dateTime('check_in')->nullable();   // Check-in datetime
            $table->dateTime('check_out')->nullable();  // Check-out datetime
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendees');
    }
};
