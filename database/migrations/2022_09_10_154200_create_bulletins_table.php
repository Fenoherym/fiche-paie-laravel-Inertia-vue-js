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
        Schema::create('bulletins', function (Blueprint $table) {
            $table->id();
            $table->date('debut_periode');
            $table->date('fin_periode');
            $table->date('date_payement');
            $table->string('mois');
            $table->float('retenue_irsa',  12, 2);
            $table->float('total_gain_brut', 12, 2);
            $table->float('total_brut_salarial', 12, 2);
            $table->float('total_cotisations_salarial', 12, 2);
            $table->float('total_cotisations_patronal', 12, 2);
            $table->float('gain_enfant_charge', 12, 2);
            $table->float('valeur_irsa', 12, 2);
            $table->float('gain_total', 12, 2);
            $table->float('retenue_salarial_total', 12, 2);
            $table->float('retenue_patronal_total', 12, 2);
            $table->foreignId('personnel_id')->constrained()->onDelete('cascade');
            $table->foreignId('id_payement');
            $table->unique(['mois', 'personnel_id']);
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
        Schema::dropIfExists('bulletins');
    }
};
