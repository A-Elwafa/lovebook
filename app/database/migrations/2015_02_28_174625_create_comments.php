<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('comments', function($table){
                $table->increments('id');
                $table->integer('post_id')->unsigned();
                $table->integer('user_id')->unsigned();
                
                $table->text('content');
                
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
            Schema::drop('comments');
	}

}
