<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->enum('type', ['online', 'onsite'])->default('online')->after('hours');
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            //
        });
    }
};
