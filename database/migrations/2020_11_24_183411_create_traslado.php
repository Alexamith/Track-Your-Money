<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraslado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traslado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cuenta_debito');
            $table->double('monto_debitado',8,2);
            $table->integer('cuenta_credito');
            $table->double('monto_acreditado',8,2);
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
        Schema::dropIfExists('traslado');
    }
}
