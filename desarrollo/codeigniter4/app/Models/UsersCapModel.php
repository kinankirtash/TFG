<?php

namespace App\models;

use CodeIgniter\Model;

class UsersCapModel extends Model
{
    protected $table = 'jugado';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_capitulo', 'id_usuario', 'porcentaje', 'ultimoDialogo'];

    public function registroUnion($id_capitulo, $id_usuario, $porcentaje, $ultimoDialogo)
    {
        $data = [
            'id_capitulo' => $id_capitulo,
            'id_usuario' => $id_usuario,
            'porcentaje' => $porcentaje,
            'ultimoDialogo' => $ultimoDialogo,
        ];
        $this->insert($data);

        return $this->insertID();
    }

    public function obtenerPorcentajeCapituloAnterior($idUsuario, $idCapitulo)
    {
        // Realiza una consulta a la base de datos para obtener el porcentaje del capítulo anterior jugado por el usuario.
        // Supongamos que tienes una tabla 'jugado' con una columna 'porcentaje' que almacena el porcentaje completado.

        $query = "SELECT porcentaje FROM jugado WHERE id_usuario = ? AND id_capitulo = ?";
        $result = $this->db->query($query, [$idUsuario, $idCapitulo - 1]);

        if ($result && $row = $result->getRow()) {
            return $row->porcentaje;
        }

        // Si no se encuentra ningún registro para el capítulo anterior, se puede considerar como si el porcentaje fuera 0%.
        return 0;
    }

    public function obtenerPorcentajeCapitulo($idUsuario, $idCapitulo)
    {
        $query = "SELECT porcentaje FROM jugado WHERE id_usuario = ? AND id_capitulo = ?";
        $result = $this->db->query($query, [$idUsuario, $idCapitulo]);

        if ($result && $row = $result->getRow()) {
            return $row->porcentaje;
        }

        return 0;
    }

    public function getCapitulosPorUsuario($usuarioID)
    {

        // Recupera los resultados.
        $capitulosRelacionados = $this->where('id_usuario', $usuarioID);

        return $capitulosRelacionados;
    }

    public function setDialogo($id, $idCapitulo, $porcentajeCap, $idDialogo)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('jugado');

        $data = [
            'porcentaje' => ($idDialogo ? $porcentajeCap : 100), // Establece 100 si $idDialogo es null
        ];

        if ($idDialogo) {
            $data['ultimoDialogo'] = $idDialogo;
        }

        $builder->where('id_capitulo', $idCapitulo);
        $builder->where('id_usuario', $id);

        return $builder->update($data);
    }

    public function obtenerUltimoDialogoGuardado($idUsuario, $idCapitulo)
    {
        $query = "SELECT ultimoDialogo FROM jugado WHERE id_usuario = ? AND id_capitulo = ?";
        $result = $this->db->query($query, [$idUsuario, $idCapitulo]);

        if ($result && $row = $result->getRow()) {
            return $row->ultimoDialogo;
        }

        return "0";
    }
}
