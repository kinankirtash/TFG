<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

function template(string $view, array $data = [])
{
    if (! file_exists(__DIR__.'/Views/'.$view.'.php')) {
        return "La pagina que buscas no existe";
    }

    return view('header', $data).view($view).view('footer');
}

function prearray($array, $stopProcess = false)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
    if ($stopProcess) {
        exit;
    }
}