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
        Schema::create('selections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('coach_id')->constrained();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('league_id');
            $table->string('color')->nullable();
            $table->foreignId('club_id')->constrained();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('codebooks');
            $table->foreign('league_id')->references('id')->on('codebooks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selections');
    }
};
