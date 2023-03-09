<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialization_university', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialization_id');
            $table->foreign('specialization_id')->references('id')->on('specializations')->cascadeOnDelete();
            $table->foreignId('university_id');
            $table->foreign('university_id')->references('id')->on('universities')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialization_university');
    }
};
