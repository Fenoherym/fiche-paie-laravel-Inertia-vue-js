<?php

namespace Database\Seeders;

use App\Models\Contrat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contrats = [
            [
                'name' => 'CDI',
                'category' => 'HC'
            ],
            [
                'name' => 'CDD',
                'category' => 'HC1'
            ]

        ];
        foreach ($contrats as $contrat) {
            Contrat::create($contrat);
        }
    }
}
