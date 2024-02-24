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
        Schema::table('memberships', function (Blueprint $table) {
            $table->foreignId('club_id')->constrained();
        });

        Schema::table('players', function (Blueprint $table) {
            $table->foreignId('club_id')->constrained();
        });

        Schema::table('membership_types', function (Blueprint $table) {
            $table->foreignId('club_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
