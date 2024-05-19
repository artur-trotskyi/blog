<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AllowedHtmlTags implements ValidationRule
{
    protected string $allowedTags;

    public function __construct()
    {
        $this->allowedTags = '<a><code><i><strong>';
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strip_tags($value, $this->allowedTags) !== $value) {
            $fail("The $attribute field contains disallowed HTML tags.");
        }
    }
}
