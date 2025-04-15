<?php

if (isset($_GET)) {

    require_once __DIR__ . "../../../config/config.php";
    require_once __DIR__ . "../../conexion.php";

    $datos = array();

    $mysqli = $conexion->query("SELECT e.id, matricula, nombre, apellido_pa, apellido_ma, carrera_id, semestre_id, s.nombre_sistema, activo FROM estudiantes e
                                INNER JOIN sistemas s ON e.sistema_id = s.id ORDER BY matricula");

    while ($dato = $mysqli->fetch_object()) {
        $datos[] = [
            "id" => $dato->id,
            "matricula" => $dato->matricula,
            "nombre" => $dato->nombre . " " . $dato->apellido_pa . " " . $dato->apellido_ma,
            "carrera_id" => $dato->carrera_id,
            "semestre_id" => $dato->semestre_id,
            "sistema_id" => $dato->nombre_sistema,
            "activo" => $dato->activo
        ];
    }

    $mysqli->free_result();
    $conexion->close();

    print_r(json_encode($datos, JSON_UNESCAPED_UNICODE));
}
