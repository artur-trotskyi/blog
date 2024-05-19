<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('post_id');
            $table->uuid('parent_id')->nullable();
            $table->uuid('user_id');
            $table->text('message');
            $table->timestamps();
            $table->softDeletes();

            $table->index('post_id');
            $table->index('parent_id');
            $table->index('user_id');
            $table->primary('id');

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
