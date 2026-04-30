<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('cover_media_id')->nullable()->after('author');
            $table->foreign('cover_media_id')->references('id')->on('medias')->nullOnDelete();
        });

        Schema::create('post_labels', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('label_id');
            $table->primary(['post_id', 'label_id']);
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->foreign('label_id')->references('id')->on('labels')->cascadeOnDelete();
        });

        Schema::create('post_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('category_id');
            $table->primary(['post_id', 'category_id']);
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['cover_media_id']);
            $table->dropColumn('cover_media_id');
        });

        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('post_labels');
    }
};
