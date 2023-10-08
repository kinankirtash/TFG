<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function __construct()
    {

    }

    public function login()
    {
        return template('login');
    }

    public function signUp()
    {
        return template('signUp');
    }
}
