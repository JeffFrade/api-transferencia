<?php

namespace App\Helpers;

class StringHelper
{
    public static function hashPassword(?string $password)
    {
        if (empty($password)) {
            return null;
        }

        return \Hash::make($password);
    }
}
