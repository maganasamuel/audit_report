<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->date('weekOf');
            $table->enum('lead_source', ['Telemarketer', 'BDM', 'Self-generated']);
            $table->json('qa');
            $table->foreignId('adviser_id');
            $table->foreignId('policy_holder_id');
            $table->timestamps();

            $table->foreign('adviser_id')->references('id')->on('advisers');
            $table->foreign('policy_holder_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audits');
    }
}
