<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
			
			$table->unsignedBigInteger('post_id');
			$table->string('name', 50);
			$table->string('email', 80);
			$table->string('text', 4000);
            $table->boolean('approved');

            $table->unsignedBigInteger('comment_answer_id')->nullable(true);
			
			$table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->foreign('comment_answer_id')->references('id')->on('post_comments')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
