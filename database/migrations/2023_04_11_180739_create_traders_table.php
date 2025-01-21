<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('address',500)->nullable();
            $table->string('phone')->nullable();
            $table->string('competent_name')->nullable();
            $table->string('competent_phone')->nullable();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();
            $table->string('fax')->nullable();
            $table->string('logo')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');

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
        Schema::dropIfExists('traders');
    }
}
