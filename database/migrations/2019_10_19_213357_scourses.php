<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Scourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scourses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cname',191);
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('school_id')->unsigned();
            $table->boolean('isActive')->default(0);
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
        Schema::dropIfExists('scourses');
    }
}
