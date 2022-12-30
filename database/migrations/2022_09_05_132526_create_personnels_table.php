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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('num_matricule')->unique();
            $table->string('name');
            $table->string('first_name');
            $table->string('sexe');
            $table->date('birthday');
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->integer('number_children')->nullable();
            $table->string('address');
            $table->float('base_salary', 12, 2);
            $table->string('CIN');
            $table->string('num_cnaps')->nullable();
            $table->string('type_renumeration');
            $table->integer('nombre')->nullable();
            $table->integer('nbr_conge')->nullable();
            $table->date('hiring_date');
            $table->date('date_of_departure')->nullable();
            $table->foreignId('contrat_id')->constrained();
            $table->foreignId('statut_id')->constrained();
            $table->foreignId('workplace_id')->constrained();
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
        Schema::dropIfExists('personnels');
    }
};
