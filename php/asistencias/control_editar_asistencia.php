<?php
if (isset($_POST)) {

    if (!empty($_POST["asistencias"]) && !empty($_POST["clase_id"]) && !empty($_POST["asistencia_id"])) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $asistencias = $_POST["asistencias"];
        $clase_id = $_POST["clase_id"];
        $asistencia_id = $_POST["asistencia_id"];

        foreach ($asistencias as $estudiante_id => $presente_id) {
            // Actualizar el registro existente
            $stmt = $conexion->prepare("UPDATE detalle_asistencia SET presente = ? WHERE asistencia_id = ? AND estudiante_id = ?");
            $stmt->bind_param("iii", $presente_id, $asistencia_id, $estudiante_id);
            $stmt->execute();
        }

        $response = [
            "status" => true,
            "titulo" => "Actualización exitosa",
            "texto" => "Se actualizó la asistencia con éxito",
            "icono" => "success"
        ];

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
