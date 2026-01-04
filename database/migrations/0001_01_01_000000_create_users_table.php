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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->enum('role', ['Super', 'Admin', 'User'])->default('User');

            // Optional contact fields (keep nullable so /register doesn’t break)
            $table->string('phone')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('town')->nullable();

            // State: 2 chars, default NY
            $table->string('state', 2)->default('NY');

            // Zipcode: max length 5 in DB, numeric enforced via validation
            $table->string('zipcode', 5)->nullable();

            // These are effectively required because they have defaults
            $table->enum('gender', ['Male', 'Female', 'Other'])->default('Male');
            $table->enum('status', ['Veteran', 'Staff'])->default('Veteran');

            $table->enum('branch', [
                'Airforce',
                'Airforce Reserve',
                'Army',
                'Army National Guard',
                'Army Reserve',
                'Coast Guard',
                'Coast Guard Reserve',
                'Marine Corps',
                'Marine Corps Reserve',
                'Navy',
                'Navy Reserve',
                'Other'
            ])->default('Army');
            $table->boolean('combat')->default(false);
            $table->boolean('profile_confirmed')->default(0);
            $table->boolean('id_confirmed')->default(0);
            $table->boolean('status_confirmed')->default(0);
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
