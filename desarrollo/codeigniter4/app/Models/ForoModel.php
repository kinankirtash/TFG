<?php

namespace App\models;

use CodeIgniter\Model;

class ForoModel extends Model
{
    protected $table = 'comentario';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_usuario', 'remitente', 'texto'];

    public function comentar($id, $nick, $mensaje)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('comentario');
        $data = [
            'id_usuario' => $id,
            'remitente' => $nick,
            'texto' => $mensaje,
        ];

        return $builder->insert($data);
    }

    public function borrarMensaje($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('comentario');

        return $builder->where('id', $id)->delete();
    }
}
