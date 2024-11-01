<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trader_id')->nullable();
            $table->foreign('trader_id')->references('id')->on('traders');
            $table->unsignedBigInteger('govern_id')->nullable();
            $table->foreign('govern_id')->references('id')->on('areas');
            $table->Integer('value')->nullable();
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
        Schema::dropIfExists('agent_prices');
    }
}
