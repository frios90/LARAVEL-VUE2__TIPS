<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rut');
            $table->string('name');
            $table->string('legal_name');
            $table->string('contact');
            $table->string('email')->unique();
            $table->integer('phone');
            $table->string('address');
            $table->date('since');
            $table->unsignedInteger('commune_id');
            $table->foreign('commune_id')->references('id')->on('communes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
