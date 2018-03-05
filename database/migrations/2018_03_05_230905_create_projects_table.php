<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            // $table->string('project');            
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('client_id')->nullable();
            $table->string('description');
            $table->enum('priority', ['high', 'medium', 'low'])->default('high');
            $table->enum('progress_update', ['yes', 'no'])->default('no');
            // $table->boolean('progress_update')->default(false);
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
        Schema::dropIfExists('projects');
    }
}
