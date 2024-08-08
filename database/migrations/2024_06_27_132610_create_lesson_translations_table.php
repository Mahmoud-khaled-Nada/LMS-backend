<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('lesson_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lesson_id');
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
            $table->string('locale');
            $table->string('name');
            $table->text('short_description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lesson_translations');
    }
};
