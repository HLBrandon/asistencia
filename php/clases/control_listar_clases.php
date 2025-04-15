<?php

if (isset($_GET)) {

    require_once __DIR__ . "../../../config/config.php";
    require_once __DIR__ . "../../conexion.php";

    $datos = array();

    $mysqli = $conexion->query("SELECT c.id, u.nombre, u.apellido_paterno, u.apellido_materno, a.nombre_asignatura, carrera_id, semestre_id, s.nombre_sistema, p.fecha_inicio, p.fecha_fin, salon_id, c.activo FROM clases c
                                INNER JOIN usuarios u ON c.profesor_id = u.id
                                INNER JOIN sistemas s ON c.sistema_id = s.id
                                INNER JOIN periodos p ON c.periodo_id = p.id
                                INNER JOIN asignaturas a ON c.asignatura_id = a.id");

    while ($dato = $mysqli->fetch_object()) {
        $datos[] = [
            "id" => $dato->id,
            "nombre" => $dato->nombre . " " . $dato->apellido_paterno . " " . $dato->apellido_materno,
            "nombre_asignatura" => $dato->nombre_asignatura,
            "carrera_id" => $dato->carrera_id,
            "semestre_id" => $dato->semestre_id,
            "nombre_sistema" => $dato->nombre_sistema,
            "periodo" => $dato->fecha_inicio . " al " . $dato->fecha_fin,
            "salon_id" => $dato->salon_id,
            "activo" => $dato->activo
        ];
    }

    $mysqli->free_result();
    $conexion->close();

    print_r(json_encode($datos, JSON_UNESCAPED_UNICODE));
}
