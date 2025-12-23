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
        Schema::create('retreat_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('retreat_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('status', [
                'going',
                'not_going',
                'waitlist',
                'cancelled',
            ])->default('going');

            $table->timestamp('rsvped_at')->nullable();
            $table->timestamps();

            // Prevent duplicate RSVPs
            $table->unique(['user_id', 'retreat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retreat_user');
    }
};
