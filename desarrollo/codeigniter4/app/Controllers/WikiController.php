<?php

namespace App\Controllers;

use App\Models\PretendientesModel;

class WikiController extends BaseController
{
    protected $pretendientesModel; // Declara una propiedad para el modelo

    public function __construct()
    {
        $this->pretendientesModel = new PretendientesModel();
    }

    public function index()
    {
        return template('wikiOpciones');
    }

    public function wikiOpcion()
    {
        return template('wiki');
    }

    public function pretendientesLista()
    {
        $path = 'baseDatos/pretendientes.JSON';
        $jsonString = file_get_contents($path);
        $jsonData = json_decode($jsonString, true);

        $data['datosJson'] = $jsonData;

        return template('pretendientes', $data);
    }

    public function verPretendiente()
    {
        $id = $this->request->getPostGet('id');
        $path = 'baseDatos/pretendientes.JSON';
        $jsonString = file_get_contents($path);
        $jsonData = json_decode($jsonString, true);
        $path2 = 'baseDatos/pretendientesSprites.JSON';
        $jsonString2 = file_get_contents($path2);
        $jsonData2 = json_decode($jsonString2, true);
        foreach ($jsonData as $actual) {
            if ($actual['id'] == $id) {
                $data['pretendiente'] = $actual;
                $data['bbdd'] = $this->pretendientesModel->obtenerPretendiente($id);
            }
        }

        return template('verPretendiente', $data);
    }

    public function personajesLista()
    {
        $path = 'baseDatos/npcs.JSON';
        $jsonString = file_get_contents($path);
        $jsonData = json_decode($jsonString, true);
        $data['datosJson'] = $jsonData;

        return template('personajes', $data);
    }

    public function verPersonaje()
    {
        $id = $this->request->getPostGet('id');
        $path = 'baseDatos/npcs.JSON';
        $jsonString = file_get_contents($path);
        $jsonData = json_decode($jsonString, true);

        foreach ($jsonData as $actual) {
            if ($actual['id'] == $id) {
                $data['personaje'] = $actual;
            }
        }

        return template('verPersonaje', $data);
    }

    public function lugaresLista()
    {
        $path = 'baseDatos/lugares.JSON';
        $jsonString = file_get_contents($path);
        $jsonData = json_decode($jsonString, true);
        $data['datosJson'] = $jsonData;

        return template('lugares', $data);
    }

    public function verLugar()
    {
        $id = $this->request->getPostGet('id');
        $path = 'baseDatos/lugares.JSON';
        $jsonString = file_get_contents($path);
        $jsonData = json_decode($jsonString, true);

        foreach ($jsonData as $actual) {
            if ($actual['id'] == $id) {
                $data['lugar'] = $actual;
            }
        }

        return template('verLugar', $data);
    }
}