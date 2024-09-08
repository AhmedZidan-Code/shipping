<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            //

            $table->text('notes')->nullale();
            $table->double('trader_collection')->default(0);
            $table->tinyInteger('paid_as_money')->default(0);
            $table->tinyInteger('paid_as_mortag3')->default(0);
          $table->string('converted_date_s', 100)->default(null);
            
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
