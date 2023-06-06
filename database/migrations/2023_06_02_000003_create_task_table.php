<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->time('begin_time');
            $table->time('end_time');
            $table->date('date');
            $table->string('description');
            $table->string('instructor_name');
            $table->integer('task_number');
            $table->foreignId('play_address_id')->constrained('address');
            $table->foreignId('makeup_address_id')->nullable()->constrained('address');
            $table->enum('status', ['lopend','inBehandeling','afgerond'])->default('lopend');
            $table->enum('task_type', ['BHV', 'EHBO', 'Examen']);
            $table->foreignId('client_id')->constrained('client', 'user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('task');
    }
}