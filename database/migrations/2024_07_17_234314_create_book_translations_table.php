<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('book_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->string('locale');
            $table->string('name');
            $table->text('description');
            $table->text('learning');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_translations');
    }
};
