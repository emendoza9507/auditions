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
        Schema::create('audition_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audition_id')->constrained()->cascadeOnDelete();
            $table->time('time');
            $table->unsignedTinyInteger('max_participants')->default(4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audition_slots');
    }
};
