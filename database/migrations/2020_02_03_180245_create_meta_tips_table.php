<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaTipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_tips', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tip_work_id');
            $table->foreign('tip_work_id')->references('id')->on('tip_works');
            $table->json('meta_data_head');
            $table->json('meta_list_staffs_in_work');
            $table->json('meta_list_days');
            $table->json('meta_percentage');
            $table->unsignedInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('meta_tips');
    }
}
