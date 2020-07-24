<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Schools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('schools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sname',191);
            $table->bigInteger('principal_id')->unsigned();//foreign
          /*  $table->foreign('principal_id')->references('id')->on('principals')->onDelete('cascade');*/
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
        //
        Schema::dropIfExists('schools');
    }
}
