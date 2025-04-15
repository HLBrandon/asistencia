<?php

if (isset($_POST)) {

    if (!empty($_POST["inscripcion_id"])) {
        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $inscripcion_id = $_POST["inscripcion_id"];

        $datos = array();

        $mysqli = $conexion->prepare("UPDATE inscripciones SET status = 1 WHERE id = ?");
        $mysqli->bind_param("i", $inscripcion_id);
        $mysqli->execute();

        $datos = [
            "status" => $mysqli->affected_rows > 0 ? true : false,
            "titulo" => $mysqli->affected_rows > 0 ? "¡Éxito!" : "¡Error!",
            "texto" => $mysqli->affected_rows > 0 ? "La inscripción se ha activado correctamente." : "No se pudo activar la inscripción.",
            "icono" => $mysqli->affected_rows > 0 ? "success" : "error"
        ];

        $mysqli->close();
        $conexion->close();

        print_r(json_encode($datos, JSON_UNESCAPED_UNICODE));
    }
}