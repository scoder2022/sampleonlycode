<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ProductAttributeRule implements Rule
{
    protected $all;
    public $custom_rules = [];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($all)
    {
        $this->all = $all;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $fields)
    {
        foreach ($fields as $key => $value) {
            if ($this->all['real_prices'][$key] == null) {
                return false;
            }
            if ($this->all['sale_prices'][$key] == null) {
                return false;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
