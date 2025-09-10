<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Services\ProfanityFilter;

class NoProfanity implements ValidationRule
{
    private $profanityFilter;

    public function __construct()
    {
        $this->profanityFilter = new ProfanityFilter();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->profanityFilter->containsProfanity($value)) {
            $reason = $this->profanityFilter->getProfanityReason($value);
            $fail("🚫 Your message contains inappropriate content and cannot be sent. Please keep your message respectful and appropriate. Reason: {$reason}");
        }
    }
}
