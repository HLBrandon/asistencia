<?php

if (isset($_GET)) {

    require_once __DIR__ . "../../../config/config.php";
    require_once __DIR__ . "../../conexion.php";

    $datos = array();

    $mysqli = $conexion->query("SELECT * FROM sistemas");

    while ($dato = $mysqli->fetch_object()) {
        $datos[] = [
            "id" => $dato->id,
            "nombre_sistema" => $dato->nombre_sistema
        ];
    }

    $mysqli->free_result();
    $conexion->close();

    print_r(json_encode($datos, JSON_UNESCAPED_UNICODE));
}
