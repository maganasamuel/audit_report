<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advisers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email');
            $table->integer('fsp_no');
            $table->string('contact_number');
            $table->text('address');
            $table->string('fap_name');
            $table->string('fap_email');
            $table->integer('fap_fsp_no');
            $table->string('fap_contact_number');
            $table->string('status'); // Active, Terminated;

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
        Schema::dropIfExists('advisers');
    }
}
