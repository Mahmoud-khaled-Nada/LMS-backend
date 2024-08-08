<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('direct_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('image')->nullable();
            $table->text('url')->nullable();
            $table->string('duration')->nullable();
            $table->string('password')->nullable();
            $table->string('meeting_id')->nullable();
            $table->enum('status', [0, 1] )->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('direct_classes');
    }
};
