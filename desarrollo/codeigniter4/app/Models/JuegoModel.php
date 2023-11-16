<?php

namespace App\Models;

use CodeIgniter\Model;

class JuegoModel extends Model
{
    protected $table = 'capitulo';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['titulo', 'numero'];

    public function numPaginas()
    {
        $this->db->from('pretendiente');
        $totalPretendientes = $this->db->count_all_results();

        $numPags = ceil($totalPretendientes / 5);

        return $numPags;
    }

    public function getPaginaCapitulo($pag)
    {
        $this->db->limit(5, ($pag - 1) * 5);
        $query = $this->db->get('pretendiente');
        $pretendientes = $query->result_array();

        return $pretendientes;
    }

    public function obtenerCapitulo($id)
    {
        return $this->where('id', $id)->first();
    }
}