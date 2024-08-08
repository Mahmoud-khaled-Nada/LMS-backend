<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('price');
            $table->enum('status' , ['0' , '1'] )->default(1);   //  1 mean Acitve 0 mean Inactive
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('packages');
    }
};
