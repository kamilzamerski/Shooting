<?php

namespace App\Validators;

use App\Validators\Abstracts\AbstractValidator;

class JsonValidator extends AbstractValidator
{
    public function validate(): bool
    {
        if(!empty($this->getValue())) {
            @json_decode($this->getValue());
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }

}