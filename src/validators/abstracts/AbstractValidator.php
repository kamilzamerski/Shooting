<?php

namespace App\Validators\Abstracts;

use App\Validators\Interfaces\ValidatorInterface;

abstract class AbstractValidator implements ValidatorInterface
{
    private $value;

    /**
     * @param $mixValue
     * @return AbstractValidator
     */
    public function setValue($mixValue): self
    {
        $this->value = $mixValue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $mixValue
     * @return bool
     */
    public static function isValid($mixValue): bool
    {
        return (new static)->setValue($mixValue)->validate();
    }

}