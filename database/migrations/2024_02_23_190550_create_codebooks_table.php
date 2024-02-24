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
        Schema::create('codebooks', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('code_type')->index();
            $table->string('value', 50)->nullable();
            $table->boolean('is_global')->default(0);
            $table->foreignId('club_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codebooks');
    }
};
