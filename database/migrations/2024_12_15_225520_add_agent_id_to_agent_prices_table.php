<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgentIdToAgentPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_prices', function (Blueprint $table) {
            $table->unsignedBigInteger('agent_id')->nullable()->after('id');
            $table->foreign('agent_id')->on('deliveries')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->dropForeign(['trader_id']);
            $table->dropColumn('trader_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agent_prices', function (Blueprint $table) {
            $table->dropColumn('agent_id');
            $table->unsignedBigInteger('trader_id')->nullable();
            $table->foreign('trader_id')->references('id')->on('traders')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }
}
