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
        Schema::table('cutting_progress', function (Blueprint $table) {
            $table->float('current_weight')->nullable()->after('start_weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cutting_progress', function (Blueprint $table) {
            $table->dropColumn('current_weight');
        });
    }
};
