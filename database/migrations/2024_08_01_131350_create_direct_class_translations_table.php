<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('direct_class_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('direct_class_id');
            $table->foreign('direct_class_id')->references('id')->on('direct_classes')->onDelete('cascade');
            $table->string('locale');
            $table->text('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('direct_class_translations');
    }
};
