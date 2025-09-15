<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RestrictPatternPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Regular expression that matches simple patterns
        $patterns = '/(abc|123|password|qwerty|abc@1245|abc123|1234|admin|welcome)/i';

        // Return false if the value matches any restricted patterns
        return !preg_match($patterns, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The password is too simple or has been restricted due to common patterns.';
    }
}
