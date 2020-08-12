<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrestamoDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamo_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('prestamo_id');
            $table->bigInteger('dispositivo_id')->nullable();
            $table->bigInteger('dispositivo_quantity')->nullable();
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
        Schema::dropIfExists('prestamo_details');
    }
}
