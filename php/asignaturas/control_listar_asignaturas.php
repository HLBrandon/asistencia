<?php

if (isset($_GET)) {

    require_once __DIR__ . "../../../config/config.php";
    require_once __DIR__ . "../../conexion.php";

    $datos = array();

    $mysqli = $conexion->query("SELECT * FROM asignaturas");

    while ($dato = $mysqli->fetch_object()) {
        $datos[] = [
            "id" => $dato->id,
            "nombre_asignatura" => $dato->nombre_asignatura
        ];
    }

    $mysqli->free_result();
    $conexion->close();

    print_r(json_encode($datos, JSON_UNESCAPED_UNICODE));
}