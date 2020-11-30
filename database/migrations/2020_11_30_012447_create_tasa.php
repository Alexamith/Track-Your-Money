<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('moneda_local');
            $table->double('monto_local',8,2);
            $table->integer('moneda_equivalente');
            $table->double('monto_equivalente',8,2);
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
        Schema::dropIfExists('tasa');
    }
}
