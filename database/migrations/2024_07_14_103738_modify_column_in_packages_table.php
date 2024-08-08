<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->double('price')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            //
        });
    }
};
