<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('question_exam_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_exam_id');
            $table->foreign('question_exam_id')->references('id')->on('question_exams')->onDelete('cascade');
            $table->string('locale');
            $table->string('question');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('question_exam_translations');
    }
};
