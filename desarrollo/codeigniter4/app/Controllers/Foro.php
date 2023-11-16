<?php

namespace App\Controllers;

use App\Models\ForoModel;
use App\Models\UsersModel;
use App\Models\MsgModel;
use App\Models\BloquearModel;

class Foro extends BaseController
{
    /**
     * @var \App\Models\MsgModel
     */
    private ForoModel $foroModel;

    private UsersModel $usersModel;

    private MsgModel $msgModel;

    protected BloquearModel $bloquearModel;

    public function __construct()
    {
        $this->foroModel = new ForoModel();
        $this->usersModel = new UsersModel();
        $this->msgModel = new MsgModel();
        $this->bloquearModel = new BloquearModel();
    }

    public function foro($fallo = null)
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

        $idUsuarioActual = session("user")['id'];

        $bloqueos = $this->bloquearModel->where('id_usuario', $idUsuarioActual)->findAll();
        $comentarios = $this->foroModel->findAll();

        foreach ($comentarios as $comentario) {
            foreach ($bloqueos as $bloqueo) {
                if ($comentario['id_usuario'] != $bloqueo['id_usuarioBlock']) {
                    $mostrarComentarios[] = $comentario;
                }
            }
        }

        // Verificar si hay resultados en la consulta antes de asignarlos a $data['comentarios']
        if ((isset($mostrarComentarios) && $mostrarComentarios != "") && ($comentarios && $comentarios != "")) {
            $data['comentarios'] = $mostrarComentarios;
        } else {
            $data['comentarios'] = $comentarios;
        }
        // Comprobar si se envió un mensaje de error
        if (isset($fallo)) {
            $data['error'] = true;
            $data['msg'] = $fallo;
        }
        $data['idUsuarioActual'] = $idUsuarioActual;

        return template('foro', $data);
    }

    public function comentar()
    {
        $mensaje = $this->request->getPost('bloqueTexto');
        $nick = session('user')['nickname'];
        $id = session('user')['id'];

        $response = '';

        // Guarda el mensaje en la base de datos
        try {
            $this->foroModel->comentar($id, $nick, $mensaje);
            // Actualizar la altura de la tabla en la sesión
            $this->actualizarAlturaTabla();
        } catch (\Exception $e) {
            $mensajeError = $e->getMessage();
            $response = 'Ha ocurrido algo imprevisto con el comentario: '.$mensajeError;
        }

        return $this->foro($response);
    }

    public function denunciarComentario()
    {
        // Obtiene el mensaje desde la solicitud POST
        $remitente = $this->request->getPostGet('name_remitente');
        $texto = $this->request->getPostGet('textoComentario');
        $mensaje = "Quiero denunciar el siguiente comentario : (".$texto.") Pertenciente a : ".$remitente;
        $tipo = "Reporte Comentario";
        // Obtiene el ID de usuario si hay una sesión iniciada, de lo contrario, es null
        $id = session('user')['id'];
        // Obtiene el nickname del usuario si hay una sesión iniciada, de lo contrario, es "Invitado"
        $nick = session('user')['nickname'];
        // Guarda el mensaje en la base de datos
        $denundiarComentario = $this->msgModel->guardarMensaje($id, $nick, $mensaje, $tipo);

        $response = '';

        if (! $denundiarComentario) {
            $response = 'Ha ocurrido algo imprevisto durante la denuncia';
        }

        return $this->foro($response);
    }

    public function borrarComentario()
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
        $password = $this->request->getPostGet('password');

        // INTENTAMOS cambiar la contrasenia
        $deleteMensaje = $this->msgModel->borrarMensaje($id);

        // COMPROBAMOS Update
        if (! $deleteMensaje) {
            $data['msg'] = 'Ha ocurrido algo imprevisto durante la eliminación';

            return template('eliminarCuenta', $data);
        }
        $data['msg'] = 'El mensaje ha sido eliminada con éxito';

        return $this->control_mensajes();
    }

    public function bloquearUsuario()
    {

        $idUsuarioBloqueado = $this->request->getPostGet('id');

        $id = session('user')['id'];

        $bloquearUsuario = $this->bloquearModel->bloquear($idUsuarioBloqueado, $id);

        $response = '';

        if (! $bloquearUsuario) {
            $response = 'Ha ocurrido algo imprevisto durante el Bloqueo';
        }

        return $this->foro($response);
    }
}