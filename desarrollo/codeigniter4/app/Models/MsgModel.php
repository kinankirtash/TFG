<?php

namespace App\models;

use CodeIgniter\Model;

class MsgModel extends Model
{
    protected $table = 'mensaje';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_usuario', 'remitente', 'texto', 'tipo'];

    public function guardarMensaje($id, $nick, $mensaje)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('mensaje');
        $data = [
            'id_usuario' => $id,
            'remitente' => $nick,
            'texto' => $mensaje,
            'tipo' => "Mensaje",
        ];

        return $builder->insert($data);
    }

    public function borrarMensaje($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('mensaje');

        return $builder->where('id', $id)->delete();
    }
}
