<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->string('department')->nullable();
            $table->date('hiredate')->nullable();
            $table->boolean('isPermanent')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
