<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id');
            $table->foreign('agent_id')->references('id')->on('deliveries');
            $table->date('date');
            $table->double('cash')->default(0);
            $table->double('cheque')->default(0);
            $table->double('total')->default(0);
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
        Schema::dropIfExists('agent_payments');
    }
}
