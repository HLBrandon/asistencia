<?php
if (isset($_POST)) {

    if (!empty($_POST["asistencias"]) && !empty($_POST["clase_id"])) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $asistencias = $_POST["asistencias"];
        $total_asistencias = count($_POST["asistencias"]);

        $clase_id = $_POST["clase_id"];
        $dia_id = date('w');
        $fecha = date("Y-m-d");
        $hora = date('H:i:s');

        if ($dia_id != 0) {

            // Verificar si la hora y el día coinciden con el horario establecido
            $stmt = $conexion->prepare("SELECT id FROM horario WHERE clase_id = ? AND dia_id = ? AND ? BETWEEN hora_inicio AND hora_fin");
            $stmt->bind_param("iis", $clase_id, $dia_id, $hora);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Continuar con el resto de la lógica

                $stmt = $conexion->prepare("SELECT COUNT(id) AS total_estudiantes FROM inscripciones WHERE clase_id = ?");
                $stmt->bind_param("i", $clase_id);
                $stmt->execute();
                $resultado = $stmt->get_result();
                $total_estudiantes = $resultado->fetch_object()->total_estudiantes;

                if ($total_asistencias == $total_estudiantes) {

                    // Verificar si ya se tomó asistencia en ese horario específico de la clase
                    $stmt = $conexion->prepare("
                        SELECT a.id 
                        FROM asistencias a
                        INNER JOIN horario h ON h.clase_id = a.clase_id 
                        WHERE a.clase_id = ? 
                        AND a.fecha = ? 
                        AND a.dia_id = ?
                        AND ? BETWEEN h.hora_inicio AND h.hora_fin
                        LIMIT 1
                    ");

                    // Debug: Imprimir valores
                    error_log("clase_id: " . $clase_id);
                    error_log("fecha: " . $fecha);
                    error_log("dia_id: " . $dia_id);
                    error_log("hora: " . $hora);

                    $stmt->bind_param("isis", $clase_id, $fecha, $dia_id, $hora);
                    $stmt->execute();
                    $stmt->store_result();

                    // Debug: Imprimir número de filas encontradas
                    error_log("Filas encontradas: " . $stmt->num_rows);

                    if ($stmt->num_rows > 0) {
                        $response = [
                            "status" => false,
                            "titulo" => "Asistencia existente",
                            "texto" => "Ya existe un registro de asistencia para esta clase en este horario específico",
                            "icono" => "error"
                        ];
                        // Debug: Confirmar que entramos en esta condición
                        error_log("Se detectó asistencia existente");
                        
                        // Asegurarnos que la respuesta se envíe
                        echo json_encode($response, JSON_UNESCAPED_UNICODE);
                        exit(); // Detener la ejecución aquí
                    } else {
                        // Inserción de datos en la tabla `asistencias`
                        $stmt = $conexion->prepare("INSERT INTO asistencias (clase_id, dia_id, hora, fecha) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("iiss", $clase_id, $dia_id, $hora, $fecha);
                        $stmt->execute();
                        // Recuperar el ID del registro insertado
                        $asistencia_id = $conexion->insert_id;

                        foreach ($asistencias as $estudiante_id => $asistencia) {
                            $stmt = $conexion->prepare("INSERT INTO detalle_asistencia (asistencia_id, estudiante_id, presente) VALUES (?, ?, ?)");
                            $stmt->bind_param("iii", $asistencia_id, $estudiante_id, $asistencia);
                            $stmt->execute();
                        }

                        $response = [
                            "status" => true,
                            "titulo" => "Asistencia exitosa",
                            "texto" => "Se registró la asistencia con éxito",
                            "icono" => "success"
                        ];
                    }

                    $stmt->close();
                    $conexion->close();
                } else {
                    $response = [
                        "status" => false,
                        "titulo" => "Debes completar toda la asistencia",
                        "texto" => "Existen asistencias pendientes",
                        "icono" => "error"
                    ];
                }
            } else {
                $response = [
                    "status" => false,
                    "titulo" => "Horario no válido",
                    "texto" => "No puedes pasar asistencia fuera del horario de clase",
                    "icono" => "error"
                ];
            }
        } else {
            $response = [
                "status" => false,
                "titulo" => "Día no válido",
                "texto" => "Es domingo, no puedes pasar asistencia",
                "icono" => "info"
            ];
        }
    } else {
        $response = [
            "status" => false,
            "titulo" => "Campos vacíos",
            "texto" => "Debes completar todo el formulario",
            "icono" => "error"
        ];
    }

    print_r(json_encode($response, JSON_UNESCAPED_UNICODE));
}
