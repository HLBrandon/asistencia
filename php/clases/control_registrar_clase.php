<?php
if (isset($_POST)) {

    if (
        !empty($_POST["profesor_id"]) and
        !empty($_POST["asignatura_id"]) and
        !empty($_POST["carrera_id"]) and
        !empty($_POST["semestre_id"]) and
        !empty($_POST["sistema_id"]) and
        !empty($_POST["periodo_id"]) and
        !empty($_POST["salon_id"]) and
        !empty($_POST["activo"]) and
        !empty(array_filter($_POST["dia"])) &&
        !empty(array_filter($_POST["hora_inicio"])) &&
        !empty(array_filter($_POST["hora_fin"]))
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $profesor_id = $_POST["profesor_id"];
        $asignatura_id = $_POST["asignatura_id"];
        $carrera_id = $_POST["carrera_id"];
        $semestre_id = $_POST["semestre_id"];
        $sistema_id = $_POST["sistema_id"];
        $periodo_id = $_POST["periodo_id"];
        $salon_id = $_POST["salon_id"];
        $activo = $_POST["activo"];

        $dias = $_POST["dia"];
        $horas_inicios = $_POST["hora_inicio"];
        $horas_fin = $_POST["hora_fin"];

        $stmt = $conexion->prepare("SELECT id FROM clases WHERE profesor_id = ? AND asignatura_id = ? AND carrera_id = ? AND semestre_id = ? AND sistema_id = ? AND periodo_id = ? AND salon_id = ?");
        $stmt->bind_param("issiiii", $profesor_id, $asignatura_id, $carrera_id, $semestre_id, $sistema_id, $periodo_id, $salon_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = [
                "status" => false,
                "titulo" => "Clase duplicada",
                "texto" => "La clase ya está registrada",
                "icono" => "error"
            ];
        } else {
            // Iniciar transacción
            $conexion->begin_transaction();
            
            try {
                // Insertar en la tabla clases
                $mysqli = $conexion->prepare("INSERT INTO clases (profesor_id, asignatura_id, carrera_id, semestre_id, sistema_id, periodo_id, salon_id, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $mysqli->bind_param("issiiisi", $profesor_id, $asignatura_id, $carrera_id, $semestre_id, $sistema_id, $periodo_id, $salon_id, $activo);
                $mysqli->execute();
                
                // Obtener el ID de la clase recién insertada
                $clase_id = $conexion->insert_id;
                
                // Preparar la inserción de horarios
                $stmt_horario = $conexion->prepare("INSERT INTO horario (clase_id, dia_id, hora_inicio, hora_fin) VALUES (?, ?, ?, ?)");
                
                // Iterar sobre los arrays de días y horas
                for ($i = 0; $i < count($dias); $i++) {
                    if (!empty($dias[$i]) && !empty($horas_inicios[$i]) && !empty($horas_fin[$i])) {
                        $stmt_horario->bind_param("iiss", $clase_id, $dias[$i], $horas_inicios[$i], $horas_fin[$i]);
                        $stmt_horario->execute();
                    }
                }
                
                // Si todo salió bien, confirmar la transacción
                $conexion->commit();
                
                $response = [
                    "status" => true,
                    "titulo" => "Registro exitoso",
                    "texto" => "La clase y sus horarios fueron creados con éxito",
                    "icono" => "success"
                ];
                
            } catch (Exception $e) {
                // Si algo salió mal, revertir la transacción
                $conexion->rollback();
                
                $response = [
                    "status" => false,
                    "titulo" => "Error en el registro",
                    "texto" => "Ocurrió un error al registrar la clase y sus horarios",
                    "icono" => "error"
                ];
            }
            
            // Cerrar las declaraciones preparadas
            if (isset($stmt_horario)) $stmt_horario->close();
            if (isset($mysqli)) $mysqli->close();
        }

        $stmt->close();
        $conexion->close();
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
