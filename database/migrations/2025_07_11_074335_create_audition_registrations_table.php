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
        Schema::create('audition_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('audition_slot_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('age');
            $table->string('parent_name')->nullable();
            $table->string('email');
            $table->string('instrument');
            $table->string('phone');
            $table->string('agreed_terms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audition_registrations');
    }
};
