<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubriques', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->integer('nombre')->nullable();
            $table->float('base')->nullable();
            $table->float('taux_part_salarial')->nullable();
            $table->float('gain')->nullable();
            $table->float('taux_part_patronal')->nullable();
            $table->integer('numero');
            $table->string('type');
            $table->boolean('isRetenue');
            $table->boolean('isImposable')->default(false);
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
        Schema::dropIfExists('rubriques');
    }
};
