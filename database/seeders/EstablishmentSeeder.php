<?php

namespace Database\Seeders;

use App\Models\Establishment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstablishmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $establishments = [
            [
                "name" => "Developpement",
                "societe_id" => 1
            ],
            [
                "name" => "Réseau",
                "societe_id" => 1
            ]
        ];

        foreach ($establishments as $establishment) {
            Establishment::create($establishment);
        }
    }
}
