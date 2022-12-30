<?php

namespace Database\Seeders;

use App\Models\Congestatut;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CongestatutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'statut' => 'en attente',
            ],
            [
                'statut' => 'refusé',
            ],
            [
                'statut' => 'accordé',
            ],
        ];

        foreach ($status as $statu) {
            Congestatut::create($statu);
        }
    }
}
