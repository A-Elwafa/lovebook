<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('likes', function($table){
                $table->increments('id');
                
                $table->integer('post_id')->unsigned();
                $table->integer('user_id')->unsigned();
                
                $table->timestamps();
                
                //indexes
                $table->foreign('post_id')
                        ->references('id')->on('posts')
                        ->onDelete('cascade');
                $table->foreign('user_id')
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
	    Schema::drop('likes');
	}

}
