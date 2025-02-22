<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraderOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trader_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('areas');
            $table->string('customer_name')->nullable();
            $table->string('customer_address', 300)->nullable();
            $table->string('customer_phone')->nullable();
            $table->dateTime('delivery_time')->nullable();
            $table->unsignedBigInteger('trader_id')->nullable();
            $table->foreign('trader_id')->references('id')->on('traders');
            $table->integer('shipment_pieces_number')->nullable();
            $table->double('shipment_value')->nullable();
            $table->double('delivery_value')->nullable();
            $table->double('total_value')->nullable();
            $table->double('delivery_ratio')->nullable();
            $table->enum('status', ['new', 'converted_to_delivery', 'total_delivery_to_customer', 'partial_delivery_to_customer', 'not_delivery'])->default('new');
            $table->text('refused_reason')->nullable();
            $table->string('converted_date')->nullable();
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->foreign('delivery_id')->references('id')->on('deliveries');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('trader_orders');
    }
}
