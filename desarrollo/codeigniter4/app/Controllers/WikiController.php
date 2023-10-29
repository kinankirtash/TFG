<?php

namespace App\Controllers;

class WikiController extends BaseController
{
    public function __construct()
    {
        //$db = \Config\Database::connect();
        //$data['User'] = $this->session->userdata('User');
    }

    public function index()
    {

        return template('wikiOpciones');
    }

    public function wikiOpcion()
    {

        //$selectedOption = $this->input->get('tipo');

        return template('wiki');
    }

    public function pretendientesLista()
    {
        return template('pretendientes');
    }

    public function personajesLista()
    {
        return template('personajes');
    }

    public function lugaresLista()
    {
        return template('lugares');
    }
}