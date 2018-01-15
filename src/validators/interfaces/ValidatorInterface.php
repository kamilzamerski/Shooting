<?php
/**
 * Created by PhpStorm.
 * User: kamilzamerski
 * Date: 14.01.2018
 * Time: 12:32
 */

namespace App\Validators\Interfaces;


interface ValidatorInterface
{

    public function validate(): bool;

    public static function isValid($mixValue): bool;

}