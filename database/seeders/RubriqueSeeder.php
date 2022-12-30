<?php

namespace Database\Seeders;

use App\Models\Rubrique;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RubriqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rubriques = [
            [
                'designation' => 'Retenue CNAPS',
                'taux_part_salarial' => 1,
                'taux_part_patronal' => 1,
                'numero' => 403,
                'type' => 'cotisations',
                'isRetenue' => true
            ],
            [
                'designation' => 'Retenue OSTIE',
                'taux_part_salarial' => 1,
                'taux_part_patronal' => 1,
                'numero' => 404,
                'type' => 'cotisations',
                'isRetenue' => true,
            ],
            [
                'designation' => 'Absence',
                'base' => 23333.33,
                'numero' => 406,
                'type' => 'brut',
                'isRetenue' => true,
            ],
            [
                'designation' => 'Enfant à charge',
                'base' => 7000.00,
                'numero' => 405,
                'type' => 'charge familiale',
                'isRetenue' => false,
            ],
            [
                'designation' => 'Heures Supp imposable',
                'base' => 7000.00,
                'nombre' => 8,
                'numero' => 435,
                'type' => 'brut',
                'isRetenue' => false,
                'isImposable' => true
            ],
            [
                'designation' => 'Heures Supp non imposable',
                'base' => 7000.00,
                'nombre' => 4,
                'numero' => 490,
                'type' => 'brut',
                'isRetenue' => false,
                'isImposable' => false
            ],
        ];


        foreach ($rubriques as $rubrique) {
            Rubrique::create($rubrique);
        }
    }
}
