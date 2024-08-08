<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id('id');
            $table->string('phone');
            $table->string('email');
            $table->string('facebook');
            $table->string('linkedin');
            $table->string('x');
            $table->string('instgram');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('contacts');
    }
};
