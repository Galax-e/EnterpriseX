<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');  
            $table->unsignedInteger('project_id');                      
            $table->unsignedInteger('created_by')->nullable();
            // $table->string('project');
            // $table->string('description');
            // $table->string('client');
            // $table->string('priority');
            // $table->enum('progress_update', ['yes', 'no'])->default('no');
            $table->enum('type', ['organization', 'client'])->default('organization');
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
        Schema::dropIfExists('teams');
    }
}
