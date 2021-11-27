<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); 
            $table->string('label');
            $table->integer('percentage'); 
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
        Schema::dropIfExists('staff_types');
    }
}
