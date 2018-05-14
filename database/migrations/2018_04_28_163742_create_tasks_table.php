<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->unsignedInteger('team_id');
            $table->boolean('from_issue')->default(0);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();   
            $table->unsignedInteger('reponsible')->nullable();         
            $table->enum('status', ['todo', 'inprogress', 'done'])->default('todo'); // 0 for todo, 1 for in-progress, 2 for completed
            $table->enum('priority', ['urgent', 'high', 'normal', 'low'])->default('normal');
            $table->string('category')->nullable(); // where the task is to be resolved
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
        Schema::dropIfExists('tasks');
    }
}
