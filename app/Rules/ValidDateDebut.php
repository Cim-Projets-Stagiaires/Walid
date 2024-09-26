<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class ValidDateDebut implements Rule
{
    protected $oldDate;

    /**
     * Create a new rule instance.
     *
     * @param  \Carbon\Carbon  $oldDate
     * @return void
     */
    public function __construct($oldDate)
    {
        $this->oldDate = Carbon::parse($oldDate);
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
        $newDate = Carbon::parse($value);
        $today = Carbon::today();

        return $newDate->equalTo($this->oldDate) || ($newDate->between($this->oldDate, $today));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be equal to the existing date or between the existing date and today.';
    }
}
