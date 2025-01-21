<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraderPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trader_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trader_id');
            $table->foreign('trader_id')->references('id')->on('traders');
            $table->date('date');
            $table->double('amount')->default(0);
            $table->mediumText('notes')->nullable();
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
        Schema::dropIfExists('trader_payments');
    }
}
