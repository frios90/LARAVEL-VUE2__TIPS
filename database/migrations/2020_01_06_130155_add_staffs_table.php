<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rut');
            $table->string('name');
            $table->string('country');
            $table->string('email')->unique();
            $table->integer('phone');
            $table->string('address');
            $table->unsignedInteger('commune_id');
            $table->foreign('commune_id')->references('id')->on('communes');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffs');
    }
}
