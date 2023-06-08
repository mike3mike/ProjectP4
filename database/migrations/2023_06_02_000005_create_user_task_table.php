<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTaskTable extends Migration
{
    public function up()
    {
        Schema::create('user_task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['geaccepteerd','geweigerd','misschien'])->nullable();
            $table->boolean('admit');
            $table->foreignId('task_id')->constrained('task');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_task');
    }
}