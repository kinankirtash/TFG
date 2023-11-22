<?php

namespace App\Controllers;

use CodeIgniter\Config\Services;

use function PHPUnit\Framework\isEmpty;

use App\Models\UsersModel;
use App\Models\UsersCapModel;
use App\Models\UsersPretModel;
use App\Models\JuegoModel;
use App\Models\MsgModel;
use App\Models\BloquearModel;

// Importa el modelo

class Users extends BaseController
{
    // Declara una propiedad para el modelo
    protected $userModel;

    protected $jugadoModel;

    protected $relacionModel;

    protected $capituloModel;

    protected $msgModel;

    protected $blockModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
        $this->jugadoModel = new UsersCapModel();
        $this->relacionModel = new UsersPretModel();
        $this->capituloModel = new JuegoModel();
        $this->msgModel = new MsgModel();
        $this->blockModel = new BloquearModel();
    }

    public function login()
    {
        // DATA DEBUG
        $data = [
            'error' => true,
            'msg' => "Rellena todos los campos",
        ];

        if (session("user")) {
            $data['msg'] = "Ya tienes una sesión iniciada";

            return template('perfil', $data);
        }

        //COMPROBAR SI EL BOTON TIENE VALOR
        if (! $this->request->getPostGet('logueo')) {
            $data['error'] = false;
        }

        //VARIABLES REQUEST
        $nick = $this->request->getPostGet('nick');
        $password = $this->request->getPostGet('password');

        // COMPROBAMOS QUE TODOS LOS CAMPOS ESTEN RELLENOS
        if (empty($nick) || empty($password)) {
            $data['form'] = [$nick, $password];
            $data['empty'] = isEmpty($nick, $password);

            return template('login', $data);
        }

        //SELECCIONAMOS EL USUARIO
        if ($this->seleccionarUsuario($nick)) {
            $result = $this->seleccionarUsuario($nick);
            if ($result['deleted'] == 0 && $result['acceso'] == 1) {
                if (password_verify($password, $result['contrasenia'])) {
                    //print_r($result);
                    $this->session->set("user", $result);

                    return template('body', $data);
                } else {
                    $data['msg'] = 'Alguno de los datos es erróneo';

                    return template('login', $data);
                }
            } else {
                $data['msg'] = 'No puedes acceder con esta cuenta';

                return template('login', $data);
            }
        } else {
            $data['msg'] = 'Alguno de los datos es erróneo';

            return template('login', $data);
        }
    }

    public function signUp()
    {
        // DATA DEBUG
        $data = [
            'error' => true,
            'msg' => "Rellena todos los campos",
        ];

        if (session("user")) {
            $data['msg'] = "Ya tienes una sesión iniciada";

            return template('perfil', $data);
        }

        //COMPROBAR SI EL BOTON TIENE VALOR
        if (! $this->request->getPostGet('registro')) {
            $data['error'] = false;
        }

        // VARIABLES REQUEST
        $nick = $this->request->getPostGet('nick');
        $nombre = $this->request->getPostGet('nombre');
        $email = $this->request->getPostGet('email');
        $password = $this->request->getPostGet('password');

        // COMPROBAMOS QUE TODOS LOS CAMPOS ESTEN RELLENOS
        if (empty($nombre) || empty($nick) || empty($email) || empty($password)) {
            $data['form'] = [$nick, $nombre, $email, $password];
            $data['empty'] = isEmpty($nick, $nombre, $email, $password);

            return template('signUp', $data);
        }
        // COMPROBAMOS QUE EL USUARIO NO EXISTE
        if ($this->seleccionarUsuario($nick)) {
            $data['msg'] = 'Ya existe un usuario con este NickName';

            return template('signUp', $data);
        }

        // INTENTAMOS INSERTAR USUARIO
        $insertUser = $this->userModel->registrarUsuario($nombre, $nick, $email, $password);
        // COMPROBAMOS INSERT
        if (! $insertUser) {
            $data['msg'] = 'Ha ocurrido algo imprevisto durante el registro';

            return template('signUp', $data);
        }

        $data['msg'] = 'Te has registrado con exito';

        return template('signUp', $data);
    }

    public function seleccionarUsuario($nick)
    {
        $usuarioExist = $this->userModel->obtenerUsuarioNick($nick);

        return ($usuarioExist);
    }

    public function seleccionarUsuarioEmail($email)
    {
        $usuarioExist = $this->userModel->obtenerUsuarioEmail($email);

        return ($usuarioExist);
    }

    public function logOut()
    {
        session_destroy();
        session_start();
        // DATA DEBUG
        $data = [
            'error' => true,
            'msg' => "Hasta Pronto",
        ];

        return template('login', $data);
    }

    public function update()
    {
        // DATA DEBUG
        $data = [
            'error' => true,
            'msg' => "Debes introducir la contraseña",
        ];

        if (! session("user")) {
            $data['msg'] = "Debes iniciar sesión";

            return template('login', $data);
        }
        //COMPROBAR SI EL BOTON TIENE VALOR
        if (! $this->request->getPostGet('update')) {
            $data['error'] = false;
        }

        $nombreImagen = $rutaImagen = '';
        //Si se sube una imagen, coger los datos
        if (! empty($_FILES['imagen']['name'])) {
            $cargarImagenResult = $this->cargarImagen();

            if ($cargarImagenResult['success']) {
                $nombreImagen = $cargarImagenResult['nombreImagen'];
                $rutaImagen = $cargarImagenResult['rutaImagen'];
            } else {
                $data['msg'] = 'Error al cargar la imagen: '.$cargarImagenResult['error'];
            }
        }

        // VARIABLES REQUEST
        $id = $this->request->getPostGet('id');
        $nick = $this->request->getPostGet('nick');
        $nombre = $this->request->getPostGet('nombre');
        $apellido1 = $this->request->getPostGet('apellido1');
        $apellido2 = $this->request->getPostGet('apellido2');
        $telefono = $this->request->getPostGet('telefono');
        $email = $this->request->getPostGet('email');
        $edad = $this->request->getPostGet('edad');
        $password = $this->request->getPostGet('password');

        if ($this->request->getPostGet('update')) {
            if (empty($password)) {
                $data['form'] = [$nick, $password];
                $data['empty'] = isEmpty($nick, $password);

                return template('perfil', $data);
            }

            if (password_verify($password, session("user")['contrasenia'])) {
                // INTENTAMOS ACTUALIZAR USUARIO

                $updateUser = $this->userModel->actualizarUsuario($id, $nombre, $apellido1, $apellido2, $nick, $edad, $email, $telefono, $nombreImagen, $rutaImagen);

                // COMPROBAMOS Update
                if ($updateUser) {
                    // Recupera los datos actualizados del usuario desde la base de datos
                    $usuarioActualizado = $this->userModel->obtenerUsuarioId($id);

                    // Actualiza la sesión del usuario con los datos actualizados
                    session()->set("user", $usuarioActualizado);

                    $data['msg'] = 'Los datos se han actualizado correctamente';
                } else {
                    $data['msg'] = 'Ha ocurrido algo imprevisto durante la actualización';
                }
            }
            $data['error'] = true;
        }

        return template('perfil', $data);
    }

    public function updatePassword()
    {
        $data = [
            'error' => true,
            'msg' => "Debes introducir la contraseña",
        ];
        if (! session("user")) {
            $data['msg'] = "Debes iniciar sesión";

            return template('login', $data);
        }
        //COMPROBAR SI EL BOTON TIENE VALOR
        if (! $this->request->getPostGet('updatePassword')) {
            $data['error'] = false;
        }

        $id = $this->request->getPostGet('id');
        $oldPassword = $this->request->getPostGet('oldPassword');
        $password = $this->request->getPostGet('password');

        if ($oldPassword == $password) {
            $data['msg'] = 'La nueva y la actual contraseña no pueden ser iguales';

            return template('cambiarContrasenia', $data);
        }
        if (password_verify($oldPassword, session("user")['contrasenia'])) {
            // INTENTAMOS cambiar la contrasenia
            $updateUser = $this->userModel->actualizarPassword($id, $password);

            // COMPROBAMOS Update
            if (! $updateUser) {
                $data['msg'] = 'Ha ocurrido algo imprevisto durante la actualización';

                return template('cambiarContrasenia', $data);
            }
            $data['msg'] = 'Se ha actualizado contraseña, vuelve a iniciar sesion';
        }

        session_destroy();
        session_start();

        return template('login', $data);
    }

    public function deleteUser()
    {
        $data = [
            'error' => true,
            'msg' => "Debes introducir la contraseña",
        ];
        if (! session("user")) {
            $data['msg'] = "Debes iniciar sesión";

            return template('login', $data);
        }
        //COMPROBAR SI EL BOTON TIENE VALOR
        if (! $this->request->getPostGet('deleteUser')) {
            $data['error'] = false;
        }

        $id = $this->request->getPostGet('id');
        $password = $this->request->getPostGet('password');

        if (password_verify($password, session("user")['contrasenia'])) {
            // INTENTAMOS cambiar la contrasenia
            $deleteUser = $this->userModel->borrarUsuario($id);

            // COMPROBAMOS Update
            if (! $deleteUser) {
                $data['msg'] = 'Ha ocurrido algo imprevisto durante la eliminación';

                return template('eliminarCuenta', $data);
            }
            $data['msg'] = 'Tu cuenta ha sido eliminada con éxito';
            session_destroy();
            session_start();

            return template('signUp', $data);
        }

        return template('eliminarCuenta', $data);
    }

    public function nivelUsuario()
    {
        $id = $this->request->getPostGet('id');
        $esAdmin = $this->request->getPostGet('esAdmin');

        // INTENTAMOS cambiar el nivel de usuario
        $updateEsAdmin = $this->userModel->esAdmin($id, $esAdmin);

        if (! $updateEsAdmin) {
            $msg = "No se ha actualizado el nivel de este usuario";
        } else {
            $msg = "Se ha actualizado el nivel de este usuario correctamente";
        }

        // Imprimir un fragmento de JavaScript
        $jsAlert = "<script>alert('".$msg."'); </script>";

        echo $jsAlert;

        // Llama a controlUsuarios al final
        return $this->controlUsuarios();
    }

    public function acceso()
    {
        $id = $this->request->getPostGet('id');
        $acceso = $this->request->getPostGet('acceso');

        // cambiamos el acceso
        $updateAcceso = $this->userModel->accesoUsuario($id, $acceso);

        // COMPROBAMOS Update
        if (! $updateAcceso) {
            $msg = "No se ha actualizado el acceso de este usuario";
        } else {
            $msg = "Se ha actualizado el acceso de este usuario correctamente";
        }

        // Imprimir un fragmento de JavaScript
        $jsAlert = "<script>alert('".$msg."'); </script>";

        echo $jsAlert;

        // Llama a controlUsuarios al final
        return $this->controlUsuarios();
    }

    public function borrarUsuario()
    {
        $id = $this->request->getPostGet('id');

        // INTENTAMOS eliminar el usuario
        $eliminarUsuario = $this->userModel->borrarUsuario($id);

        // COMPROBAMOS eliminar
        if (! $eliminarUsuario) {
            $msg = "No se ha podido eliminar este usuario";
        } else {
            $msg = "Se ha eliminado el usuario correctamente";
        }

        // Imprimir un fragmento de JavaScript
        $jsAlert = "<script>alert('".$msg."'); </script>";

        echo $jsAlert;

        // Llama a controlUsuarios al final
        return $this->controlUsuarios();
    }

    public function cargarImagen()
    {
        $data['success'] = false;

        if (session("user")) {
            helper(['form', 'url']);
            $validation = \Config\Services::validation();

            $config['upload_path'] = FCPATH.'assets/uploads/'; // Directorio donde se guardarán las imágenes
            $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; // Tipos de archivos permitidos
            $config['max_size'] = 2048; // Tamaño máximo del archivo en kilobytes

            $this->validate([
                'imagen' => 'uploaded[imagen]|max_size[imagen,2048]|ext_in[imagen,gif,jpg,png,jpeg,bmp]',
            ]);

            $file = $this->request->getFile('imagen');

            if ($file->getError() !== UPLOAD_ERR_OK) {
                // La carga de la imagen falló, manejar el error según tus necesidades
                $data['error'] = $file->getErrorString();
            } else {
                $data['success'] = true;
                // La imagen se cargó correctamente, guardar detalles en la base de datos
                $file->move($config['upload_path']);
                $nombreImagen = $file->getName();
                $rutaImagen = base_url('assets/uploads/'.$nombreImagen);// Ruta completa de la imagen en el servidor

                $data['nombreImagen'] = $nombreImagen;
                $data['rutaImagen'] = $rutaImagen;
            }
        }

        return $data;
    }

    public function controlUsuarios()
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

        // Si el usuario ha iniciado sesión y es un administrador, continúa con la lógica para mostrar la lista de usuarios.
        $userID = session('user')['id'];

        // Condiciones para la consulta
        $this->userModel->where('id !=', $userID);
        $this->userModel->where('deleted', 0);

        // Obtén los usuarios para la página actual
        $data['usuarios'] = $this->userModel->findAll();

        return template('usuarios', $data);
    }

    public function verOtroPerfil($mensaje = null, $id = null)
    {
        // DATA DEBUG
        $data = [
            'error' => false,
            'msg' => "Debes introducir la contraseña",
        ];

        if (! session("user")) {
            $data = [
                'error' => true,
                'msg' => "Debes iniciar sesión",
            ];

            return template('login', $data);
        }

        if ($mensaje != null) {
            $data = [
                'error' => true,
                'msg' => $mensaje,
            ];
        }

        if ($id != null) {
            $idUsuario = $id;
        } else {
            $idUsuario = $this->request->getPost('id_remitente');
        }

        // También puedes verificar si $idUsuario está vacío o no es numérico
        if (empty($idUsuario)) {
            $data = [
                'error' => true,
                'msg' => "ID de usuario no válido",
            ];

            return template('verOtroPerfil', $data);
        }

        $data['usuario'] = $this->userModel->find($idUsuario);

        return template('verOtroPerfil', $data);
    }

    public function denunciarUsuario()
    {
        // Obtiene el mensaje desde la solicitud POST
        $usuario = $this->request->getPostGet('usuario');
        $idUsuario = $this->request->getPostGet('id');
        $mensaje = "Quiero denunciar al siguiente Usuario : (".$usuario.") por conducta propiada ";
        $tipo = "Reporte Usuario";
        // Obtiene el ID de usuario si hay una sesión iniciada, de lo contrario, es null
        $id = session('user')['id'];
        // Obtiene el nickname del usuario si hay una sesión iniciada, de lo contrario, es "Invitado"
        $nick = session('user')['nickname'];
        // Guarda el mensaje en la base de datos
        $denundiarUsuario = $this->msgModel->guardarMensaje($id, $nick, $mensaje, $tipo);

        $response = '';

        if (! $denundiarUsuario) {
            $response = 'Ha ocurrido algo imprevisto durante la denuncia';
        }

        return $this->verOtroPerfil($response, $idUsuario);
    }


/*
    public function olvide_contrasenia()
    {
        // DATA DEBUG
        $data = [
            'error' => true,
            'msg' => "Rellena todos los campos",
        ];

        if (session("user")) {
            $data['msg'] = "Ya tienes una sesión iniciada";

            return template('perfil', $data);
        }

        //COMPROBAR SI EL BOTON TIENE VALOR
        if (! $this->request->getPostGet('enviarCorreo')) {
            $data['error'] = false;
        }

        //VARIABLES REQUEST
        $emailToSend = $this->request->getPostGet('email');

        // COMPROBAMOS QUE TODOS LOS CAMPOS ESTEN RELLENOS
        if (empty($emailToSend)) {
            $data['form'] = [$emailToSend];
            $data['empty'] = isEmpty($emailToSend);

            return template('olvidoContrasenia', $data);
        }

        //SELECCIONAMOS EL USUARIO
        if ($this->seleccionarUsuarioEmail($emailToSend)) {
            $result = $this->seleccionarUsuarioEmail($emailToSend);
            if ($result['deleted'] == 0 && $result['acceso'] == 1) {

                $temporalPass = $this->generarTemporalPass();
                $generarTemporalPass = $this->userModel->temporalPass($emailToSend, $temporalPass);

                if (! $generarTemporalPass) {
                    $data['msg'] = 'Ha ocurrido algo imprevisto generando su pase temporal';

                    return template('olvidoContrasenia', $data);
                }

                $email = \Config\Services::email();

                $email->setFrom('1998maoc@gmail.com');
                $email->setTo('maoc1998@gmail.com');
                //$email->setCC('another@another-example.com');
                //$email->setBCC('them@their-example.com');

                $email->setSubject('Email Test');
                $email->setMessage('Testing the email class.'.$temporalPass);

                if (! $email->send()) {
                    $data['msg'] = 'Ha ocurrido algo inesperado enviando su pase temporal.'.$email->printDebugger(['headers']);;

                    return template('olvidoContrasenia', $data);
                }
                $data['msg'] = 'Se le ha enviado su pase temporal, revise su email';

                return template('login', $data);
            } else {
                $data['msg'] = 'No puedes acceder con esta cuenta';

                return template('olvidoContrasenia', $data);
            }
        } else {
            $data['msg'] = 'Alguno de los datos es erróneo';

            return template('olvidoContrasenia', $data);
        }
    }

    public function newPassword()
    {
        $data = [
            'error' => true,
            'msg' => "Debes introducir la contraseña",
        ];
        if (! session("user")) {
            $data['msg'] = "Debes iniciar sesión";

            return template('login', $data);
        }
        if (! session("user")['temporal_pass']) {
            $data['msg'] = "No has olvidado la contraseña";

            return template('perfil', $data);
        }
        //COMPROBAR SI EL BOTON TIENE VALOR
        if (! $this->request->getPostGet('newPass')) {
            $data['error'] = false;
        }

        $id = $this->request->getPostGet('id');
        $password = $this->request->getPostGet('password');

        if (session("user")['temporal_pass']) {
            // INTENTAMOS cambiar la contrasenia
            $updateUser = $this->userModel->nuevaContrasenia($id, $password);

            // COMPROBAMOS Update
            if (! $updateUser) {
                $data['msg'] = 'Ha ocurrido algo imprevisto durante la actualización';

                return template('nuevaContrasenia', $data);
            }
            $data['msg'] = 'Se ha actualizado contraseña, Inicia sesión';
        }

        session_destroy();
        session_start();

        return template('login', $data);
    }

    public function generarTemporalPass()
    {
        $letras = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numeros = '0123456789';

        // Mezcla las letras y los números
        $cadenaAleatoria = str_shuffle($letras.$numeros);

        // Toma los primeros 4 caracteres como letras y los siguientes 2 como números
        $temporalPass = substr($cadenaAleatoria, 0, 4).substr($cadenaAleatoria, 4, 2);

        return $temporalPass;
    }
*/
}





