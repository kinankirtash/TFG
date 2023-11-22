<?php

namespace App\models;

use CodeIgniter\Model;
use \CodeIgniter\Model\PaginationTrait;

class UsersModel extends Model
{
    protected $table = 'usuario';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'nickname', 'email', 'contrasenia'];

    public function registrarUsuario($nombre, $nick, $email, $password)
    {
        //Hasheamos la contraseña
        $hashContrasenia = password_hash($password, PASSWORD_BCRYPT);
        $data = [
            'nombre' => $nombre,
            'nickname' => $nick,
            'email' => $email,
            'contrasenia' => $hashContrasenia,
        ];
        //prearray($data);
        $this->insert($data);

        return $this->insertID();
    }

    public function actualizarUsuario(
        $id,
        $nombre,
        $apellido1,
        $apellido2,
        $nick,
        $edad,
        $email,
        $telefono,
        $nombreImg,
        $rutaImg
    ) {
        $db = \Config\Database::connect();
        $builder = $db->table('usuario');

        $data = [
            'nombre' => $nombre,
            'apellido1' => $apellido1,
            'apellido2' => $apellido2,
            'nickname' => $nick,
            'edad' => $edad,
            'email' => $email,
            'telefono' => $telefono,
            'profile_image' => $nombreImg,
            'url' => $rutaImg,
        ];

        $builder->where('id', $id);

        return $builder->update($data);
    }

    public function actualizarPassword($id, $password)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('usuario');
        $hashContrasenia = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'contrasenia' => $hashContrasenia,
        ];

        $builder->where('id', $id);

        return $builder->update($data);
    }

    public function borrarUsuario($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('usuario');

        // Verifica cuántos usuarios tienen esAdmin=1, excluyendo al usuario actual
        $countAdminUsers = $builder->where('esAdmin', 1)->where('id !=', $id)->countAllResults();

        // Verifica si el usuario actual es administrador
        $esAdminActual = $builder->select('esAdmin')->where('id', $id)->get()->getRow()->esAdmin;

        if ($esAdminActual == 1 && $countAdminUsers === 1) {
            // Si el usuario actual es el único administrador, no se permite la eliminación
            return false;
        }

        // Si el usuario no es administrador o hay otros administradores, procede con la eliminación
        $data = [
            'deleted' => true,
        ];
        $builder->where('id', $id);

        return $builder->update($data);
    }

    public function esAdmin($id, $esAdmin)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('usuario');

        if ($esAdmin) {
            $data = [
                'esAdmin' => false,
            ];
        } else {
            $data = [
                'esAdmin' => true,
            ];
        }

        $builder->where('id', $id);

        return $builder->update($data);
    }

    public function accesoUsuario($id, $acceso)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('usuario');

        if ($acceso) {
            $data = [
                'acceso' => false,
            ];
        } else {
            $data = [
                'acceso' => true,
            ];
        }

        $builder->where('id', $id);

        return $builder->update($data);
    }

    public function avatar($id, $avatar)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('usuario');

        $data = [
            'avatar' => $avatar,
        ];

        $builder->where('id', $id);
        // Actualiza el avatar en la sesión
        session("user")['avatar'] = $avatar;

        return $builder->update($data);
    }

    public function obtenerUsuarioNick($nick)
    {
        return $this->where('nickname', $nick)->first();
    }

    public function obtenerUsuarioId($id)
    {
        return $this->where('id', $id)->first();
    }

/*
    public function obtenerUsuarioEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function nuevaContrasenia($id, $password)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('usuario');
        $hashContrasenia = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'contrasenia' => $hashContrasenia,
            'temporal_pass' => null,
        ];

        $builder->where('id', $id);

        return $builder->update($data);
    }

    public function temporalPass($email, $temporalPass)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('usuario');
        $hashTemporalPass = password_hash($temporalPass, PASSWORD_BCRYPT);

        $data = [
            'temporal_pass' => $hashTemporalPass,
        ];

        $builder->where('email', $email);

        return $builder->update($data);
    }
*/
}
