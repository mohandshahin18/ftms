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
        Schema::table('adverts', function (Blueprint $table) {
            
            $table->foreignId('trainer_id')->after('image')->on('trainers')->cascadeOnDelete()->nullable();
            $table->foreignId('company_id')->after('trainer_id')->on('companies')->cascadeOnDelete()->nullable();
            $table->foreignId('teacher_id')->after('company_id')->on('teachers')->cascadeOnDelete()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adverts', function (Blueprint $table) {
            //
        });
    }
};
