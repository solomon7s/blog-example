<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('body');
            $table->timestamps();

            $table->foreignUuid('post_id')
                ->onDelete('cascade')
                ->constrained('posts');

            $table->foreignUuid('created_by')
                ->nullable()
                ->onDelete('cascade')
                ->constrained('users');

            $table->foreignUuid('updated_by')
                ->nullable()
                ->onDelete('cascade')
                ->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
