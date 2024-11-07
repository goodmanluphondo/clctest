<?php

namespace Controllers;

use Models\User;

class Authentication
{
    public static function login($email, $password)
    {
        die('not ready to log in yet');
    }

    public static function register($first_name, $last_name, $username, $password)
    {
        $user = User::where(['username' => $username]);
    }
}