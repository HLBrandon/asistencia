<?php

if (isset($_GET)) {

    require_once __DIR__ . "../../../config/config.php";
    require_once __DIR__ . "../../conexion.php";

    $datos = array();

    $mysqli = $conexion->query("SELECT u.id, nombre, apellido_paterno, apellido_materno, correo, r.nombre_role, activo FROM usuarios u
                                INNER JOIN roles r ON u.role_id = r.id
                                WHERE u.role_id != 1");

    while ($dato = $mysqli->fetch_object()) {
        $datos[] = [
            "id" => $dato->id,
            "nombre" => $dato->nombre . " " . $dato->apellido_paterno . " " . $dato->apellido_materno,
            "correo" => $dato->correo,
            "nombre_role" => $dato->nombre_role,
            "activo" => $dato->activo
        ];
    }

    $mysqli->free_result();
    $conexion->close();

    print_r(json_encode($datos, JSON_UNESCAPED_UNICODE));
}
