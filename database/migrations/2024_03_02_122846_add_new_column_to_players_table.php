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
            $table->foreignId('selection_id')->nullable()->constrained();
            $table->date('date_joined')->nullable();
            $table->date('date_left')->nullable();
            $table->smallInteger('height')->nullable();
            $table->smallInteger('weight')->nullable();
            $table->smallInteger('number_on_jersey')->nullable();
            $table->boolean('is_captain')->default(0)->nullable();
            $table->boolean('is_foreigner')->default(0)->nullable();

            $table->string('place_of_birth', 50)->nullable();
            $table->string('jmb', 13)->nullable();
            $table->string('address', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('phone_number', 16)->nullable();
            $table->string('phone_number_secondary', 16)->nullable();
            $table->text('notes')->nullable();

            $table->boolean('is_sick')->default(0)->nullable();
            $table->text('health_notes')->nullable();

            $table->unsignedBigInteger('dominant_leg')->nullable();
            $table->unsignedBigInteger('gear_size')->nullable();
            $table->unsignedBigInteger('level_of_education')->nullable();
            $table->unsignedBigInteger('education_status')->nullable();
            $table->unsignedBigInteger('education_institution')->nullable();

            $table->foreign('dominant_leg')->references('id')->on('codebooks');
            $table->foreign('gear_size')->references('id')->on('codebooks');
            $table->foreign('level_of_education')->references('id')->on('codebooks');
            $table->foreign('education_status')->references('id')->on('codebooks');
            $table->foreign('education_institution')->references('id')->on('codebooks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            //
        });
    }
};
