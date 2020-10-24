<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('uuiid');
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('price')->nullable();
            $table->date('date')->nullable();
            $table->string('quantity')->nullable();
            $table->string('stage')->nullable();
            $table->string('url')->nullable();
            $table->string('id')->nullable();
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
        Schema::dropIfExists('products');
    }
}
