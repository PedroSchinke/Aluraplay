<?php

namespace Dbseller\Aluraplay\Domain\Helpers;

class StringHelper
{
    public static function startsWith(string $haysatck, string $needle)
    {
        return substr($haysatck, 0, strlen($needle)) === $needle;
    }
}