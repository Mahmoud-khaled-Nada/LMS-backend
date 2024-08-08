<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->date('expire_date');
            $table->bigInteger('new_price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('offers');
    }
};
