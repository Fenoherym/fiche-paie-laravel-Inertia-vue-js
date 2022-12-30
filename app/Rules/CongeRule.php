<?php

namespace App\Rules;

use App\Models\Conge;
use Illuminate\Contracts\Validation\Rule;

class CongeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private $personnel_id, private $year, private $nbr_conge)
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $conges = Conge::where('personnel_id', $this->personnel_id)->where('year', $this->year)->get();
        $pris = 0;
        foreach ($conges as $conge) {
            $pris = $pris + $conge->pris;
        }
        return $pris <= $this->nbr_conge;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Vous avez dépassé le nombre de congé maximal pour cette personne' . $this->nbr_conge;
    }
}
