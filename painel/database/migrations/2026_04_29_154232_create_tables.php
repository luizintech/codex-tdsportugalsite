<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 60);
            $table->string('short_description', 1500)->nullable(true);
            $table->string('slug', 250);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 60);
            $table->string('short_description', 1500)->nullable(true);
            $table->string('slug', 250);
            $table->timestamps();
        });

        Schema::create('medias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename', 150);
            $table->string('path', 100);
            $table->string('slug', 250);
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 80);
            $table->text('content');
            $table->string('slug', 250);
            $table->string('author', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('medias');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('labels');
    }
};
