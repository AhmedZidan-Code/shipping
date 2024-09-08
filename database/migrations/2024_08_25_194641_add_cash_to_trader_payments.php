<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCashToTraderPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trader_payments', function (Blueprint $table) {
            $table->double('cash')->default(0)->after('amount');
            $table->double('cheque')->default(0)->after('cash');
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
            $table->dropColumn(['cash', 'cheque']);
        });
    }
}
