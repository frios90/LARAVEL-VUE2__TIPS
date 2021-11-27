<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tip_works', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('amount_cash');
            $table->integer('amount_debit');
            $table->integer('amount_credit');
            $table->integer('total_amount');                   
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('working_id');/**mañana, tarde, noche... */
            $table->foreign('working_id')->references('id')->on('workings');
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
        Schema::dropIfExists('tip_works');
    }
}
