<?php

namespace App\Controllers;

use App\Models\MsgModel;
use App\Models\UsersModel;

class Mensajes extends BaseController
{
    /**
     * @var \App\Models\MsgModel
     */
    private MsgModel $msgModel;

    private UsersModel $usersModel;

    public function __construct()
    {
        $this->msgModel = new MsgModel();
        $this->usersModel = new UsersModel();
    }

    public function contacta()
    {
        return template('contacta');
    }

    public function guardarmensajes()
    {
        // Obtiene el mensaje desde la solicitud POST
        $mensaje = $this->request->getPost('mensaje');
        $tipo = "Mensaje";
        // Obtiene el ID de usuario si hay una sesión iniciada, de lo contrario, es null
        $id = session('user') ? session('user')['id'] : null;
        // Obtiene el nickname del usuario si hay una sesión iniciada, de lo contrario, es "Invitado"
        $nick = session('user') ? session('user')['nickname'] : 'Invitado';
        // Guarda el mensaje en la base de datos
        $guardarMsg = $this->msgModel->guardarMensaje($id, $nick, $mensaje, $tipo);
        if (! $guardarMsg) {
            $response = 'Ha ocurrido algo imprevisto durante el envío';
        } else {
            $response = 'Mensaje enviado';
        }
        $data['msg'] = $response;

        return template('contacta', $data);
    }

    public function control_mensajes()
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

        if (! session("user")['esAdmin']) {
            // Si el usuario no es un administrador, muestra un mensaje y redirige a la página de perfil.
            $data['error'] = true;
            $data['msg'] = "No tienes acceso a esta página";

            return template('perfil', $data);
        }
        $data['mensajes'] = $this->msgModel->findAll();

        return template('mensajes', $data);
    }

    public function deleteMsg()
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

        if (! session("user")['esAdmin']) {
            // Si el usuario no es un administrador, muestra un mensaje y redirige a la página de perfil.
            $data['error'] = true;
            $data['msg'] = "No tienes acceso a esta página";

            return template('perfil', $data);
        }

        //COMPROBAR SI EL BOTON TIENE VALOR
        if (! $this->request->getPostGet('deleteMsg')) {
            $data['error'] = false;
        }

        $id = $this->request->getPostGet('id');

        $deleteMensaje = $this->msgModel->borrarMensaje($id);

        // COMPROBAMOS Update
        if (! $deleteMensaje) {
            $data['msg'] = 'Ha ocurrido algo imprevisto durante la eliminación';

            return template('eliminarCuenta', $data);
        }
        $data['msg'] = 'El mensaje ha sido eliminada con éxito';

        return $this->control_mensajes();
    }

    public function denunciarUsuario()
    {

    }
}