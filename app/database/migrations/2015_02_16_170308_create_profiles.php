<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfiles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('profiles', function($table){
                $table->integer('user_id')->unsigned();
                
                // basic info
                $table->string('location', 60)->nullable();
                $table->string('school', 100)->nullable();
                $table->enum('gender', array('Male', 'Female'))->nullable();
                $table->date('dob')->nullable();
                $table->text('about_me')->nullable();
                
                // profile picture and thumbnails
                $table->string('profPic_name', 60)->default('defaultProfile.jpg');
                $table->string('profPic_path', 255)->default('img/');
                // thumbnail
                $table->string('profPic_name_thumb', 60)->default('defaultProfile.jpg');
                $table->string('profPic_path_thumb', 255)->default('img/');
                //mini thumbnail - for search
                $table->string('profPic_name_mini_thumb', 60)->default('defaultProfile_mini.jpg');
                $table->string('profPic_path_mini_thumb', 255)->default('img/');
                
                //laravel
                $table->timestamps();
                
                //indexes and keys
                $table->primary('user_id');
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
            Schema::drop('profiles');
	}

}
