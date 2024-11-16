<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_id');
            $table->foreign('delivery_id')->references('id')->on('deliveries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('month');
            $table->year('year');
            $table->unsignedDouble('base_salary')->default(0);
            $table->unsignedDouble('total_salary')->default(0);
            $table->bigInteger('orders_count')->default(0);
            $table->unsignedDouble('company_profit')->default(0);
            $table->unsignedDouble('delivery_shipping')->default(0);
            $table->unsignedDouble('shipping_after_fees')->default(0);
            $table->unsignedDouble('delivery_fees')->default(0);
            $table->unsignedDouble('solar')->default(0);
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
        Schema::dropIfExists('salaries');
    }
}
