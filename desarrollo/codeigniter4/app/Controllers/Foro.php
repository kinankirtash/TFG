<?php

namespace App\Controllers;

class Foro extends BaseController
{
    public function __construct()
    {

    }

    public function foro()
    {
        return template('foro');
    }
}