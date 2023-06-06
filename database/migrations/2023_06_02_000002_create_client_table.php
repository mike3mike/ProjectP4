<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('company_name');
            $table->string('contact_person_name');
            $table->integer('contact_person_phone_number');
            $table->string('invoice_email_address');
            $table->foreignId('invoice_address_id')->constrained('address')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('client');
    }
}




