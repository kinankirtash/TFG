<?php

namespace App\Controllers;

use App\Models\JuegoModel;
use App\Models\PretendientesModel;
use App\Models\UsersModel;
use App\Models\UsersCapModel;
use App\Models\UsersPretModel;

class Play extends BaseController
{
    protected $pretendienteModel;

    protected $juegoModel;

    protected $userModel;

    protected $jugadoModel;

    protected $relacionModel;

    public function __construct()
    {
        $this->pretendienteModel = new PretendientesModel();
        $this->juegoModel = new JuegoModel();
        $this->userModel = new UsersModel();
        $this->jugadoModel = new UsersCapModel();
        $this->relacionModel = new UsersPretModel();
    }

    public function relaciones()
    {
        $usuarioID = (int) session("user")['id'];

        // Obtén los capítulos disponibles y relacionados como arreglos de ID
        $capitulosDisponibles = array_column($this->juegoModel->select('id')->findAll(), 'id');
        $capitulosRelacionados = array_column($this->jugadoModel->select('id_capitulo')->where('id_usuario', $usuarioID)->findAll(), 'id_capitulo');

        $pretendientesDisponibles = array_column($this->pretendienteModel->select('id')->findAll(), 'id');
        $pretendientesRelacionados = array_column($this->relacionModel->select('id_pretendiente')->where('id_usuario', $usuarioID)->findAll(), 'id_pretendiente');

        $capitulosFaltantes = array_diff($capitulosDisponibles, $capitulosRelacionados);
        $pretendientesFaltantes = array_diff($pretendientesDisponibles, $pretendientesRelacionados);

        foreach ($capitulosFaltantes as $capituloID) {
            $this->jugadoModel->registroUnion($capituloID, $usuarioID, 0, '0');
        }

        foreach ($pretendientesFaltantes as $pretendienteID) {
            $this->relacionModel->registroUnion($pretendienteID, $usuarioID, 0, 0);
        }
    }

    public function juega()
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
        $usuarioID = (int) session("user")['id'];

        $this->relaciones();

        $avatar = session("user")['avatar'];
        if ($avatar == null) {
            //var_dump(session("user"));

            return template('elegirAvatar');
        }

        $data["capitulos"] = $this->juegoModel->findAll();
        $data["porcentajes"] = $this->jugadoModel->select('id_capitulo, porcentaje')->where('id_usuario', $usuarioID)->findAll();

        $path = 'baseDatos/capitulos.JSON';
        $jsonString = file_get_contents($path);
        $jsonData = json_decode($jsonString, true);
        $data['datosJson'] = $jsonData;

        //var_dump($data['porcentajes']);

        return template('play', $data);
    }

    public function recreativos()
    {
        if (! session("user")) {
            // Si el usuario no ha iniciado sesión, muestra un mensaje y redirige a la página de inicio de sesión.
            $data['error'] = true;
            $data['msg'] = "Debes iniciar sesión";

            return template('login', $data);
        }

        return template('recreativos');
    }

    public function seleccionarCapitulo()
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

        $idUsuario = session("user")['id'];
        $idCapitulo = $this->request->getPostGet('id');

        // Consulta la base de datos para obtener el porcentaje del capítulo anterior jugado por el usuario.
        $porcentaje = $this->jugadoModel->obtenerPorcentajeCapitulo($idUsuario, $idCapitulo);
        if ($porcentaje == 100) {
            // Capitulo completado.
            $msg = "Ya has completado este capitulo.";
            $jsAlert = "<script>alert('".$msg."'); </script>";
            echo $jsAlert;

            return $this->juega();
        }

        $porcentajeAnterior = $this->jugadoModel->obtenerPorcentajeCapituloAnterior($idUsuario, $idCapitulo);

        if ($idCapitulo == 1 || $porcentajeAnterior == 100) {
            // El porcentaje del capítulo anterior es del 100% o es el primer capítulo
            return $this->jugarCapitulo($idCapitulo);
        } else {
            // El porcentaje del capítulo anterior no es del 100%, por lo que no se puede jugar el nuevo capítulo.
            $msg = "No puedes jugar aún a este capítulo.";
            $jsAlert = "<script>alert('".$msg."'); </script>";
            echo $jsAlert;

            return $this->juega();
        }
    }

    public function llamarDatos()
    {
        $lugares = 'baseDatos/lugares.JSON';
        $lugaresString = file_get_contents($lugares);
        $lugaresData = json_decode($lugaresString, true);
        $data['lugares'] = $lugaresData;

        $pretendientes = 'baseDatos/pretendientes.JSON';
        $pretendientesString = file_get_contents($pretendientes);
        $pretendientesData = json_decode($pretendientesString, true);
        $data['pretendientes'] = $pretendientesData;

        $npcs = 'baseDatos/npcs.JSON';
        $npcsString = file_get_contents($npcs);
        $npcsData = json_decode($npcsString, true);
        $data['npcs'] = $npcsData;

        $dialogos = 'baseDatos/dialogos.JSON';
        $dialogosString = file_get_contents($dialogos);
        $dialogosData = json_decode($dialogosString, true);
        $data['dialogos'] = $dialogosData;

        $capitulos = 'baseDatos/capitulos.JSON';
        $capitulosString = file_get_contents($capitulos);
        $capitulosData = json_decode($capitulosString, true);
        $data['capitulos'] = $capitulosData;

        return $data;
    }

    public function obtenerOpcionesDeRespuesta($dialogoActual)
    {
        // Accede a las opciones de respuesta del diálogo actual
        if ($dialogoActual['tipo'] === 'pregunta' && isset($dialogoActual['opciones'])) {
            return $dialogoActual['opciones'];
        }

        return []; // Devuelve un array vacío si no hay opciones o si no es una pregunta
    }

    public function jugarCapitulo($idCapitulo, $dialogoActual = null, $opcionElegida = null)
    {
        $data = $this->llamarDatos();
        $data['idCapitulo'] = $idCapitulo;
        $capitulos = $data['capitulos'];

        foreach ($capitulos as $capitulo) {
            if ($capitulo['id'] == $idCapitulo) {
                $data['capitulo'] = $capitulo;
            }
        }
        $dialogos = $data['dialogos'];
        $dialogosCapituloActual = [];

        foreach ($dialogos as $dialogo) {
            if ($dialogo['id_capitulo'] == $idCapitulo) {
                $dialogosCapituloActual[] = $dialogo;
            }
        }

        // Verifica si el usuario tiene un diálogo guardado en la base de datos
        $idUsuario = session("user")['id'];
        $ultimoDialogoGuardado = $this->jugadoModel->obtenerUltimoDialogoGuardado($idUsuario, $idCapitulo);

        if ($ultimoDialogoGuardado !== "0") {
            foreach ($dialogosCapituloActual as $dialogo) {
                if ($dialogo['id'] == $ultimoDialogoGuardado) {
                    $dialogoActual = $dialogo;
                    break;
                }
            }
        }

        if ($dialogoActual === null) {
            $data['dialogo_actual'] = reset($dialogosCapituloActual);
        } else {
            $data['dialogo_actual'] = $dialogoActual;
            // Obtén las opciones de respuesta del diálogo actual
            if ($dialogoActual['tipo'] === 'pregunta' && isset($dialogoActual['opciones'])) {
                $data['opciones_respuesta'] = $dialogoActual['opciones'];
            } else {
                $data['opciones_respuesta'] = [];
            }
        }

        $tipoPersonaje = $data['dialogo_actual'];
        if (! isset($tipoPersonaje['id_Npc']) && ! isset($tipoPersonaje['id_Pretendiente'])) {
            $data['personaje'] = null;
        } else {
            if (isset($tipoPersonaje['id_Npc'])) {
                $npcs = $data['npcs'];
                foreach ($npcs as $npc) {
                    if ($npc['id'] == $tipoPersonaje['id_Npc']) {
                        $data['personaje'] = $npc;
                    }
                }
            }
            if (isset($tipoPersonaje['id_Pretendiente'])) {
                $pretendientes = $data['pretendientes'];
                foreach ($pretendientes as $pretendiente) {
                    if ($pretendiente['id'] == $tipoPersonaje['id_Pretendiente']) {
                        $data['personaje'] = $pretendiente;
                    }
                }
            }
        }
        if ($opcionElegida !== null) {
            $idAfectado = $opcionElegida['id_afectado'];
            $reaccion = $opcionElegida['reaccion'];
            $pretendiente = $this->pretendienteModel->obtenerPretendiente($idAfectado);
            $this->relacionModel->actualizarRelacionPretendiente($idUsuario, $pretendiente, $reaccion);
        }

        return template('jugarCapitulo', $data);
    }

    public function avanzarDialogo()
    {
        $idCapitulo = $this->request->getPostGet('id');
        $data = $this->llamarDatos();
        $dialogos = $data['dialogos'];
        $dialogosCapituloActual = [];

        foreach ($dialogos as $dialogo) {
            if ($dialogo['id_capitulo'] == $idCapitulo) {
                $dialogosCapituloActual[] = $dialogo;
            }
        }

        $idSiguienteDialogo = $this->request->getPostget('siguiente_dialogo');
        $idPregunta = $this->request->getPostget('pregunta');
        $idRespuestaSeleccionada = $this->request->getPostget('respuesta');
        //var_dump($idRespuestaSeleccionada);
        if ($idSiguienteDialogo) {
            // Encuentra el diálogo con el id que coincida con el siguiente diálogo
            foreach ($dialogosCapituloActual as $dialogo) {
                if ($dialogo['id'] == $idSiguienteDialogo) {
                    $siguienteDialogo = $dialogo;
                    break;
                }
            }
            if (isset($siguienteDialogo)) {
                $this->guardarUltimoDialogo($idCapitulo, $idSiguienteDialogo);

                return $this->jugarCapitulo($idCapitulo, $siguienteDialogo);
            }
        } elseif ($idPregunta) {
            foreach ($dialogosCapituloActual as $pregunta) {
                if ($pregunta['id'] == $idPregunta) {
                    $objetoPregunta = $pregunta;
                    break;
                }
            }
            $opciones = $objetoPregunta['opciones'];
            foreach ($opciones as $opcion) {
                if ($opcion['id'] == $idRespuestaSeleccionada) {
                    $opcionElegida = $opcion;
                    break;
                }
            }
            //var_dump($opcionElegida['id']);
            //return $this->jugarCapitulo($idCapitulo);
            $idDialogoConsecuente = $opcionElegida['siguiente_dialogo'];
            foreach ($dialogosCapituloActual as $dialogo) {
                if ($dialogo['id'] == $idDialogoConsecuente) {
                    $siguienteDialogo = $dialogo;
                    break;
                }
            }
            if ($siguienteDialogo) {
                $this->guardarUltimoDialogo($idCapitulo, $idDialogoConsecuente);

                return $this->jugarCapitulo($idCapitulo, $siguienteDialogo, $opcionElegida);
            }
        } else {
            // Si no hay más diálogos después de revisar todas las opciones y consecuencias, muestra el mensaje de capítulo completado.
            $msg = '¡Has completado este capítulo!';
            $jsAlert = "<script>alert('".$msg."'); </script>";
            echo $jsAlert;
            $this->guardarUltimoDialogo($idCapitulo);

            return $this->juega();
        }
    }

    public function guardarUltimoDialogo($idCapitulo, $idDialogo = null)
    {
        $id = session("user")['id'];
        $porcentajeCap = $this->calcularPorcentajeCapitulo($idCapitulo, $idDialogo);
        $ultimoDialogo = $this->jugadoModel->setDialogo($id, $idCapitulo, $porcentajeCap, $idDialogo);
        $logFile = fopen("log.txt", "a"); // "a" abre el archivo en modo de adición

        if ($logFile && $ultimoDialogo) {
            $logMessage = "Último diálogo guardado con éxito."; // Mensaje que deseas registrar
            fwrite($logFile, date('Y-m-d H:i:s').": ".$logMessage.PHP_EOL); // Escribe el mensaje en el archivo
            fclose($logFile); // Cierra el archivo
        }
    }

    public function calcularPorcentajeCapitulo($idCapitulo, $idDialogo = null)
    {
        $data = $this->llamarDatos();
        $dialogos = $data['dialogos'];
        $dialogosCapituloActual = [];

        foreach ($dialogos as $dialogo) {
            if ($dialogo['id_capitulo'] == $idCapitulo) {
                $dialogosCapituloActual[] = $dialogo;
            }
        }

        // Encuentra la posición del diálogo correspondiente a $idDialogo
        $posicionDialogo = 0;
        foreach ($dialogosCapituloActual as $index => $dialogo) {
            if ($dialogo['id'] == $idDialogo) {
                $posicionDialogo = $index;
                break;
            }
        }

        // Verifica si el diálogo actual es igual al último diálogo del capítulo
        $ultimoDialogoCapitulo = end($dialogosCapituloActual);
        $esUltimoDialogo = ($idDialogo == $ultimoDialogoCapitulo['id']);

        // Verifica si el id guardado en la base de datos es igual al último id de los diálogos
        $idGuardado = $this->jugadoModel->obtenerUltimoDialogoGuardado(session("user")['id'], $idCapitulo);
        $esIdGuardadoIgualAlUltimo = ($idGuardado == $ultimoDialogoCapitulo['id']);

        // Calcula el porcentaje completado
        if ($esIdGuardadoIgualAlUltimo) {
            $porcentajeCompletado = 100;
        } elseif ($esUltimoDialogo) {
            $porcentajeCompletado = 100;
        } else {
            $totalDialogos = count($dialogosCapituloActual);
            $porcentajeCompletado = ($posicionDialogo >= $totalDialogos) ? 100 : ($posicionDialogo / $totalDialogos) * 100;
        }

        return $porcentajeCompletado;
    }

    public function saveAvatar()
    {
        $id = session("user")['id'];
        $avatar = $this->request->getPostGet('avatar');

        // cambiamos el acceso
        $selecAvatar = $this->userModel->avatar($id, $avatar);

        // COMPROBAMOS Update
        if (! $selecAvatar) {
            $msg = "No se ha seleccionado el avatar";
        } else {
            $msg = "Se ha seleccionado el avatar";
            // Recupera los datos actualizados del usuario desde la base de datos
            $usuarioActualizado = $this->userModel->obtenerUsuarioId($id);

            // Actualiza la sesión del usuario con los datos actualizados
            session()->set("user", $usuarioActualizado);
        }

        // Imprimir un fragmento de JavaScript
        $jsAlert = "<script>alert('".$msg."'); </script>";

        echo $jsAlert;

        // Llama a controlUsuarios al final
        return $this->juega();
    }
}