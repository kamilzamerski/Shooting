<?php

namespace App\Validators;

use App\Validators\Abstracts\AbstractValidator;

class Results10from15Validator extends AbstractValidator
{
    public function validate(): bool
    {
        $jsonData = json_decode($this->getValue());
        if (!isset($jsonData->points)) {
            return false;
        }
        if (!isset($jsonData->in10)) {
            return false;
        }
        $arrPoints = (array) $jsonData->points;
        if (sizeof($arrPoints) == 15) {
            return true;
        }
        return false;
    }
}