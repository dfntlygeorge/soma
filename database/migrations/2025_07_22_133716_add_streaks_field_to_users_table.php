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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('streak')->default(0);
            $table->date('last_logged_at')->nullable();
            $table->integer('longest_streak')->default(0);
            $table->json('earned_badges')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('streak');
            $table->dropColumn('last_logged_at');
            $table->dropColumn('longest_streak');
            $table->dropColumn('earned_badges');
        });
    }
};
