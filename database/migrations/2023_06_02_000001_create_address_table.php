<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTable extends Migration
{
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('street_name');
            $table->integer('house_number');
            $table->string('postal_code');
            $table->string('city');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('address');
    }
}
