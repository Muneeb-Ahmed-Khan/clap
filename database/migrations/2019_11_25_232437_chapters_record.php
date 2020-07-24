<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChaptersRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapters_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('chapterName',191);
            $table->bigInteger('chapter_id')->unsigned();
            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->bigInteger('student_id')->unsigned();
            $table->longText('data');
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
        Schema::dropIfExists('chapters_record');
    }
}
