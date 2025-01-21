<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_by');
            $table->date('date');
            $table->foreign('expense_by')
                ->references('id')
                ->on('admins')
                ->onDelete('cascade');
            $table->double('value');
            $table->unsignedBigInteger('setting_id');
            $table->foreign('setting_id')
                ->references('id')
                ->on('administrative_settings')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                $table->string('notes')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
