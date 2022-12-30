<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personnel>
 */
class PersonnelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type_renumeration = [
            "Horaire",
            "Journalier",
            "mensuel"
        ];
        shuffle($type_renumeration);
        return [
            "num_matricule" => $this->faker->numerify(),
            "name" => $this->faker->name(),
            "first_name" => $this->faker->firstName(),
            "sexe" => array_rand(['M', 'F'], 1),
            "birthday" => $this->faker->date(),
            "telephone" => $this->faker->phoneNumber(),
            "email" => $this->faker->email(),
            "number_children" => random_int(0, 4),
            "address" => $this->faker->address(),
            "base_salary" => floatval(random_int(100000, 1000000)),
            "CIN" => random_int(00000001, 99999999),
            "num_cnaps" => random_int(00001, 99999),
            "type_renumeration" => $type_renumeration[0],
            "hiring_date" => $this->faker->date(),
            "contrat_id" => random_int(1, 2),
            "statut_id" => random_int(1, 2),
            "workplace_id" => random_int(1, 2),
        ];
    }
}
