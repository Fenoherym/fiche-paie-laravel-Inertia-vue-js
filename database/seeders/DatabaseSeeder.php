<?php

namespace Database\Seeders;

use App\Models\Workplace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SocieteSeeder::class,
            EstablishmentSeeder::class,
            WorkplaceSeeder::class,
            StatutSeeder::class,
            RoleSeeder::class,
            ContratSeeder::class,
            RubriqueSeeder::class,
            IrsaSeeder::class,
            CongestatutSeeder::class
        ]);

        \App\Models\User::factory(5)->create();
        // \App\Models\Personnel::factory(5)->create();
    }
}