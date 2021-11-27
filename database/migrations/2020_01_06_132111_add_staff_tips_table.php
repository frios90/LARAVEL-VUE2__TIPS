<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStaffTipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_tips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount');
            $table->unsignedInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staffs');
            $table->unsignedInteger('staff_type_id');
            $table->foreign('staff_type_id')->references('id')->on('staff_types');
            $table->unsignedInteger('tip_work_id');
            $table->foreign('tip_work_id')->references('id')->on('tip_works');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('staff_tips');
    }
}
