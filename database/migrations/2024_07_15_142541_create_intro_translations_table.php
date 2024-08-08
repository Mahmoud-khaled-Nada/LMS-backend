<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('intro_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('intro_id');
            $table->foreign('intro_id')->references('id')->on('intros')->onDelete('cascade');
            $table->string('locale');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('intro_translations');
    }
};
