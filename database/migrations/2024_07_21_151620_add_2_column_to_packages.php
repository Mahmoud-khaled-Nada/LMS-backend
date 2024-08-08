<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->double('average_rate')->default(0);
            $table->integer('count')->default(0);
        });
    }


    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            //
        });
    }
};
