<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create("users", function($table) {
                // login info and name
                $table->increments("id");
                $table->string("email", 50);
                $table->string("password", 60);
                $table->string("first_name", 25);         
                $table->string("last_name", 50);
                $table->string("middle_name", 25)->nullable();
                $table->enum("activated", array('0', '1'));
                $table->string("code", 40)->nullable();

                // laravel attributes
                $table->rememberToken();
                $table->timestamps();

                // indexes
                $table->unique("email");
                $table->index(array('first_name', 'last_name', 'middle_name'), 'full_name_index');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop("users");
	}

}
