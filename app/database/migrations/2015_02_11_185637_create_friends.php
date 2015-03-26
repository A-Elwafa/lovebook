<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriends extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create("friends", function($table) {
                // login info and name
                $table->increments("id");
                $table->integer('user1_id')->unsigned();
                $table->integer('user2_id')->unsigned();
                $table->enum('accepted', array('0', '1'))->default('0');
                
                // laravel attributes
                $table->timestamps();

                // indexes and keys
                $table->foreign('user1_id')
                        ->references('id')->on('users')
                        ->onDelete('cascade');
                $table->foreign('user2_id')
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
	    Schema::drop("friends");
	}

}
