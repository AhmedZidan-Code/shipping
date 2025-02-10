<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrdersCountInTraderPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trader_payments', function (Blueprint $table) {
            $table->bigInteger('orders_count')->default(0)->after('trader_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trader_payments', function (Blueprint $table) {
            $table->dropColumn('orders_count');
        });
    }
}
