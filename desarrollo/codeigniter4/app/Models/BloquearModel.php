<?php

namespace App\models;

use CodeIgniter\Model;

class BloquearModel extends Model
{
    protected $table = 'bloqueo';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_usuarioBlock', 'id_usuario'];

    public function bloquear($idBlock, $id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('bloqueo');
        $data = [
            'id_usuarioBlock' => $idBlock,
            'id_usuario' => $id,
        ];

        return $builder->insert($data);
    }
}
