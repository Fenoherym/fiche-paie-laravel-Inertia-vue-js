<?php

namespace Database\Seeders;

use App\Models\Workplace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workplaces = [
            [
                "name" => "Developpeur",
                "establishment_id" => 1
            ],
            [
                "name" => "Admin Réseau",
                "establishment_id" => 2
            ]
        ];

        foreach ($workplaces as $workplace) {
            Workplace::create($workplace);
        }
    }
}
