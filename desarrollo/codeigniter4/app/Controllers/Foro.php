<?php

namespace App\Controllers;

use App\Models\ForoModel;
use App\Models\UsersModel;

class Foro extends BaseController
{
    /**
     * @var \App\Models\MsgModel
     */
    private ForoModel $foroModel;

    private UsersModel $usersModel;

    public function __construct()
    {
        $this->foroModel = new ForoModel();
        $this->usersModel = new UsersModel();
    }

    public function foro($data = null)
    {
        $data = [
            'error' => false,
        ];
        if (! session("user")) {
            // Si el usuario no ha iniciado sesión, muestra un mensaje y redirige a la página de inicio de sesión.
            $data['error'] = true;
            $data['msg'] = "Debes iniciar sesión";

            return template('login', $data);
        }

        $comentarios = $this->foroModel->findAll();

        // Verificar si hay resultados en la consulta antes de asignarlos a $data['comentarios']
        if ($comentarios) {
            $data['comentarios'] = $comentarios;
        }

        return template('foro', $data);
    }
}