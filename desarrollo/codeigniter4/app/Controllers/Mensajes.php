<?php

namespace App\Controllers;

use App\Models\MsgModel;

class Mensajes extends BaseController
{
    /**
     * @var \App\Models\MsgModel
     */
    private MsgModel $msgModel;

    public function __construct()
    {
        $this->msgModel = new MsgModel();
    }

    public function guardarmensajes()
    {
        $mensaje = $this->request->getPostGet('mensaje');

        if (session('user')) {
            $id = session('user')["id"];
            $nick = session('user')["nickname"];
        } else {
            $id = null;
            $nick = "Invitado";
        }
        // Guarda el mensaje en la base de datos
        $guardarMsg = $this->msgModel->guardarMensaje($id, $nick, $mensaje);
        if (! $guardarMsg) {
            $response = 'Ha ocurrido algo imprevisto durante el envío';
        } else {
            $response = 'Mensaje enviado';
        }
        $jsAlert = "<script>alert('".$response."'); </script>";
        echo $jsAlert;

        return redirect()->to(current_url());
    }

    public function control_mensajes()
    {
        return template('mensajes');
    }
}