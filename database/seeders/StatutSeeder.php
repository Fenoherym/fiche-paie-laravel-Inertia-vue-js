<?php

namespace Database\Seeders;

use App\Models\Statut;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuts = [
            [
                "name" => "cadre"
            ],
            [
                "name" => "non cadre"
            ],
        ];

        foreach ($statuts as $statut) {
            Statut::create($statut);
        }
    }
}
