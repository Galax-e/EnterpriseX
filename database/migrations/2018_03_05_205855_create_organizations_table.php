<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country')->nullable();
            $table->string('zip')->nullable();
            // $table->enum('level', ['easy', 'hard']);
            $table->enum('number_of_staff', ['just you', '2-9', '10-99', '100-299', '300']);
            $table->string('phone_number')->nullable();
            $table->string('description')->nullable();
            $table->string('industry')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('organization');
    }
}
