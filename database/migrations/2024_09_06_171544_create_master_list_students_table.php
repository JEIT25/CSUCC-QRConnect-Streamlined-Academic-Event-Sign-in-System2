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
        Schema::create('master_list_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_list_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('master_list_id')->references('id')->on('master_lists')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_list_students');
    }
};
