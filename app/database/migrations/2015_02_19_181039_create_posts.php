<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosts extends Migration {

	public function up()
	{
            Schema::create('posts', function($table){
                $table->increments("id");
                $table->integer('user_id')->unsigned();
                $table->integer('posted_to_user_id')->unsigned();
                $table->text('content');
                
                $table->timestamps();
                
                // indexes
                $table->foreign('user_id')
                        ->references('id')->on('users')
                        ->onDelete('cascade');
                $table->foreign('posted_to_user_id')
                        ->references('id')->on('users')
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
            Schema::drop('posts');
	}
}