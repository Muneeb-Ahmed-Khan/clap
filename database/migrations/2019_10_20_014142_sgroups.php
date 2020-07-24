<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Sgroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgroups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cname',191);
            $table->bigInteger('gnumber');
            $table->bigInteger('student_id');
            $table->bigInteger('school_id');
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
        Schema::dropIfExists('sgroups');
    }
}
