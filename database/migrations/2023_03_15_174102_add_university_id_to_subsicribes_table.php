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
        Schema::table('subsicribes', function (Blueprint $table) {
            $table->unsignedBigInteger('university_id');
            $table->foreign('university_id')->after('student_id')->references('id')->on('universities')->cascadeOnDelete();
            $table->unsignedBigInteger('specialization_id');
            $table->foreign('specialization_id')->after('student_id')->references('id')->on('specializations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subsicribes', function (Blueprint $table) {
            //
        });
    }
};
