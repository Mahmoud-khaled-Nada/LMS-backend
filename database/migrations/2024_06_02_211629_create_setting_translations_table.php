<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
               // $table->foreignId('settings_id');
            // $table->foreignId('settings_id')->constrained('settings')->onDelete('cascade');
            $table->unsignedBigInteger('setting_id');
            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');
            $table->string('locale');
            $table->longText('footer_description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('setting_translations');
    }
};
