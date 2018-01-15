<?php

namespace App\Exceptions;


class RequiredValueException extends \Exception
{
    protected $code = 400;
}