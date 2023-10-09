<?php

namespace App\Controllers;

class Play extends BaseController
{
    public function __construct()
    {

    }

    public function juega()
    {
        return template('play');
    }

    public function recreativos()
    {
        return template('recreativos');
    }
}