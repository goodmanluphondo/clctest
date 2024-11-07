<?php
namespace Helpers;

class Session
{
    public static function user()
    {
        return $_SESSION["user"];
    }
}