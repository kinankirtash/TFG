<?php

namespace App\Controllers;

use function PHPUnit\Framework\isEmpty;
use App\Models\UsersModel;

// Importa el modelo

class Users extends BaseController
{
    protected $userModel; // Declara una propiedad para el modelo

    public function __construct()
    {
        $this->userModel = new UsersModel();
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
                $updateUser = $this->userModel->actualizarUsuario($id, $nombre, $apellido1, $apellido2, $nick, $edad, $email, $telefono);
                // COMPROBAMOS Update
                if (! $updateUser) {
                    $data['msg'] = 'Ha ocurrido algo imprevisto durante la actualización';

                    return template('perfil', $data);
                }
            }
            $data['error'] = false;
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
            $updateUser = $this->userModel->borrarUsuario($id);

            // COMPROBAMOS Update
            if (! $updateUser) {
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

        $data['usuarios'] = $this->userModel->where('id !=', $userID)->where('deleted', 0)->findAll();

        return template('usuarios', $data);
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

        // INTENTAMOS cambiar la contrasenia
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
}





