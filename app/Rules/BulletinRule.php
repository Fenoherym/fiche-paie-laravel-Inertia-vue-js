<?php

namespace App\Rules;

use App\Models\Bulletin;
use Illuminate\Contracts\Validation\Rule;

class BulletinRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($mois, $personnel_id)
    {
        $this->mois = $mois;
        $this->personnel_id = $personnel_id;
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
        return Bulletin::where('personnel_id', $this->personnel_id)->where('mois', $this->mois)->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Cette bulletin existe déjà';
    }
}
