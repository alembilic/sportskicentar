<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->string('full_name')->virtualAs("CONCAT(first_name, ' ', last_name)");
        });

        Schema::table('membership_types', function (Blueprint $table) {
            $table->string('full_name')->virtualAs("CONCAT(name, ' - ', price, 'KM')");
        });

        Schema::table('coaches', function (Blueprint $table) {
            $table->string('full_name')->virtualAs("CONCAT(first_name, ' ', last_name)");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
