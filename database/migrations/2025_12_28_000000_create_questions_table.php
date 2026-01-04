<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();

            $table->text('expect');                       // required
            $table->text('suffer')->default('None');      // default None
            $table->text('allergies')->default('None');   // default None
            $table->text('concerns')->default('None');    // default None
            $table->string('conduct');                    // required (Agree/Disagree)

            $table->timestamps();

            // One set of answers per user per event
            $table->unique(['user_id', 'event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
