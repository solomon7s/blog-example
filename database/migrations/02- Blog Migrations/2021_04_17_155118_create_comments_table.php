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
                ->constrained('posts')
                ->onDelete('cascade');

            $table->foreignUuid('created_by')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignUuid('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
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
