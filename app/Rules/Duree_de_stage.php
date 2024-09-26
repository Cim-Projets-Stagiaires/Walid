<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Duree_de_stage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($value);

        if ($startDate->diffInDays($endDate) < 45) {
            $fail('The duration between start date and end date must be at least 45 days.');
        }
    }
    protected $startDate;

    public function __construct($startDate)
    {
        $this->startDate = $startDate;
    }

}
