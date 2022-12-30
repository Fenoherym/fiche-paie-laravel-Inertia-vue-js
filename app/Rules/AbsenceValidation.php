<?php

namespace App\Rules;

use App\Models\Absence;
use Illuminate\Contracts\Validation\Rule;

class AbsenceValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($mois, $personnal_id)
    {
        $this->mois = $mois;
        $this->personnel_id = $personnal_id;
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
        return Absence::where('personnel_id', $this->personnel_id)->where('mois', $this->mois)->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Cette absence existe déjà';
    }
}
