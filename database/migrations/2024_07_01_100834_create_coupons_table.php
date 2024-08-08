<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id('id');
            $table->string('code');
            $table->integer('number_of_use');
            $table->integer('remaining');
            $table->date('expire_date');
            $table->integer('value');
            $table->enum('type', [0, 1] )->default(0);
            $table->enum('status', [0, 1] )->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('coupons');
    }
};
