<?php

namespace Database\Seeders;

use App\Models\Irsa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IrsaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $irsas = [
            [
                "base_min" => 0,
                "base_max" => 350000,
                "taux" => 0
            ],
            [
                "base_min" => 350000,
                "base_max" => 400000,
                "taux" => 5
            ],
            [
                "base_min" => 400000,
                "base_max" => 500000,
                "taux" => 10
            ],
            [
                "base_min" => 500000,
                "base_max" => 600000,
                "taux" => 15
            ],
            [
                "base_min" => 600000,
                "taux" => 20
            ],
        ];

        foreach ($irsas as $irsa) {
            Irsa::create($irsa);
        }
    }
}
