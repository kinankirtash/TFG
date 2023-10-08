<?php

namespace App\Models;

use CodeIgniter\Model;

class wiki_model extends Model
{
    public function numPaginas()
    {
        $this->db->from('pretendiente');
        $totalPretendientes = $this->db->count_all_results();

        $numPags = ceil($totalPretendientes / 5);

        return $numPags;
    }

    public function getPaginaPretendiente($pag)
    {
        $this->db->limit(5, ($pag - 1) * 5);
        $query = $this->db->get('pretendiente');
        $pretendientes = $query->result_array();

        return $pretendientes;
    }
}