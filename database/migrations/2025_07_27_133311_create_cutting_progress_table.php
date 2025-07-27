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
        Schema::create('cutting_progress', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Associates the cutting phase with a specific user

            $table->date('started_at');
            // The date the user officially started this cutting phase

            $table->decimal('start_weight', 5, 2);
            // The user's weight at the start of the cut (e.g., 78.00)

            $table->decimal('goal_weight', 5, 2);
            // The target weight for this cut (e.g., 65.00)

            $table->integer('duration_days')->nullable();
            // Optional: Total planned length of the cut in days (e.g., 120)

            $table->json('milestones')->nullable();
            // Optional: Stores milestone data like 1kg, 2kg lost, dates unlocked, etc.

            $table->boolean('active')->default(true);
            // Indicates whether this is the current active cut

            $table->timestamps();
            // created_at and updated_at for tracking lifecycle
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutting_progress');
    }
};
