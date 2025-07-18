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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Onboarding fields (all nullable)
            $table->integer('age')->nullable();
            $table->enum('sex', ['male', 'female'])->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->enum('goal', ['lose', 'maintain', 'gain'])->nullable();
            $table->enum('activity_level', ['sedentary', 'light', 'moderate', 'active', 'extra'])->nullable();
            $table->integer('daily_calorie_target')->nullable();
            $table->integer('daily_protein_target')->nullable();
            $table->integer('daily_carbs_target')->nullable();
            $table->integer('daily_fat_target')->nullable();

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
