<?php

namespace App\Services;
use Validator;

class ApiValidator
{
    /**
     * -------------------------
     * Custom API Validator
     * -------------------------
     * 
     * @param array $fields
     * @param array $rules
     * @return object $validator
     */
    public function validate($fields, $rules)
    {
        $validator = Validator::make($fields, $rules);

        return $validator->fails() ? $validator->messages() : '';
    }
}