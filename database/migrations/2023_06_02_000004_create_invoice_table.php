<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('signature');
            $table->string('specifics');
            $table->foreignId('address_id')->constrained('address');
            $table->foreignId('task_id')->constrained('task');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}