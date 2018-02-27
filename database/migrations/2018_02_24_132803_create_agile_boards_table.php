<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgileBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agile_boards', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('film_id');
            $table->string('description');
            $table->string('type')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->default(0);
            $table->integer('status')->default(0); // 0 for todo, 1 for in-progress, 2 for completed
            // $table->
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
        Schema::dropIfExists('agile_boards');
    }
}
