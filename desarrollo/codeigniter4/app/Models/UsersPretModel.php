<?php

namespace App\models;

use CodeIgniter\Model;

class UsersPretModel extends Model
{
    protected $table = 'relacion';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_pretendiente', 'id_usuario', 'interes', 'nivel'];

    public function registroUnion($id_pretendiente, $id_usuario, $interes, $nivel)
    {
        $data = [
            'id_pretendiente' => $id_pretendiente,
            'id_usuario' => $id_usuario,
            'interes' => $interes,
            'relacion' => $nivel,
        ];
        //prearray($data);
        $this->insert($data);

        return $this->insertID();
    }

    public function obtenerRelacionPretendiente($id, $idPretendiente)
    {
        return $this->where('id_usuario', $id)->where('id_pretendiente', $idPretendiente)->first();
    }

    public function actualizarRelacionPretendiente($id, $pretendiente, $reaccion)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('relacion');
        $subidaInteres = 0;
        $bajadaInteres = 0;
        switch ($pretendiente['dificultad']) {
            case "facil":
                $subidaInteres = 25;
                $bajadaInteres = 5;
                break;
            case "neutra":
                $subidaInteres = 20;
                $bajadaInteres = 10;
                break;
            case "dificil":
                $subidaInteres = 15;
                $bajadaInteres = 15;
                break;
        }
        // Obtén la relación actual desde la base de datos
        $relacionActual = $builder->where('id_usuario', $id)->where('id_pretendiente', $pretendiente['id'])->get()->getRow();
        if ($relacionActual) {
            // Si encontraste una relación existente, actualiza el campo 'interes' de la base de datos.
            if ($reaccion === 'buena') {
                $nuevoInteres = $relacionActual->interes + $subidaInteres;
                if ($nuevoInteres >= 100) {
                    // Si el interés llega a 100 o más, aumenta el nivel de relación en 1 y reinicia el interés a 0.
                    $nuevoNivel = $relacionActual->nivel + 1;
                    $nuevoInteres = 0;
                    $builder->where('id_usuario', $id)->where('id_pretendiente', $pretendiente['id'])->update([
                        'nivel' => $nuevoNivel,
                        'interes' => $nuevoInteres,
                    ]);
                } else {
                    $builder->where('id_usuario', $id)->where('id_pretendiente', $pretendiente['id'])->update(['interes' => $nuevoInteres]);
                }
            } elseif ($reaccion === 'mala') {
                // Si la reacción es 'mala', resta el valor de bajadaInteres al interés actual.
                $nuevoInteres = $relacionActual->interes - $bajadaInteres;
                if ($nuevoInteres < 0) {
                    // Asegúrate de que el interés no sea menor que 0.
                    $nuevoInteres = 0;
                }
                $builder->where('id_usuario', $id)->where('id_pretendiente', $pretendiente['id'])->update(['interes' => $nuevoInteres]);
            }
        }
    }
}
