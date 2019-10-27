<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('follower');
            $table->unsignedBigInteger('following');
            $table->unsignedSmallInteger('status')->index(); // index() use for search
            $table->timestamps();

            $table->foreign('follower')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('following')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('followings');
    }
}
