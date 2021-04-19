<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->mediumText('content');
            $table->boolean('is_featured')->index();

            $table->timestamps();

            $table->foreignUuid('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignUuid('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
