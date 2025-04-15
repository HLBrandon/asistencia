<?php

if (isset($_GET)) {

    require_once __DIR__ . "../../../config/config.php";
    require_once __DIR__ . "../../conexion.php";

    $datos = array();

    $mysqli = $conexion->query("SELECT * FROM periodos");

    while ($dato = $mysqli->fetch_object()) {

        $fecha_inicio = strftime("%d de %B del %Y", strtotime($dato->fecha_inicio));
        $fecha_fin = strftime("%d de %B del %Y", strtotime($dato->fecha_fin));

        $datos[] = [
            "id" => $dato->id,
            "fecha_inicio" => $fecha_inicio,
            "fecha_fin" => $fecha_fin,
            "activo" => $dato->activo
        ];
    }

    $mysqli->free_result();
    $conexion->close();

    print_r(json_encode($datos, JSON_UNESCAPED_UNICODE));
}
