<?php

namespace App\Controllers;

use App\Models\PretendientesModel;
use App\Models\UsersPretModel;

class WikiController extends BaseController
{
    // Declara una propiedad para el modelo
    protected $pretendientesModel;

    protected $relacionModel;

    public function __construct()
    {
        $this->pretendientesModel = new PretendientesModel();
        $this->relacionModel = new UsersPretModel();
    }

    public function index()
    {
        return template('wikiOpciones');
    }

    public function control()
    {
        return template('control');
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
        if (session("user")) {
            $id = session("user")['id'];
        }
        $idPretendiente = $this->request->getPostGet('id');
        $path = 'baseDatos/pretendientes.JSON';
        $jsonString = file_get_contents($path);
        $jsonData = json_decode($jsonString, true);
        foreach ($jsonData as $actual) {
            if ($actual['id'] == $idPretendiente) {
                $data['pretendiente'] = $actual;
                $data['bbdd'] = $this->pretendientesModel->obtenerPretendiente($idPretendiente);
                if (session("user")) {
                    $data['relacion'] = $this->relacionModel->obtenerRelacionPretendiente($id, $idPretendiente);
                }
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