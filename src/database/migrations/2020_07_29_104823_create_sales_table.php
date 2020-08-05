<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->integer('id_product');
            $table->foreign('id_product')->references('id')->on('products');
            // $table->integer('id_user');
            // $table->foreign('id_user')->references('id')->on('users');
            $table->string('name_client')->nullable();
            $table->string('cpf_client')->nullable();
            $table->integer('quantitysale');
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
        Schema::dropIfExists('sales');
    }
}
