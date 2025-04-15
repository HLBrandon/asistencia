<?php

if (isset($_GET)) {

    require_once __DIR__ . "../../../config/config.php";
    require_once __DIR__ . "../../conexion.php";

    $datos = array();

    $mysqli = $conexion->query("SELECT i.clase_id, a.nombre_asignatura, c.carrera_id, c.semestre_id, s.nombre_sistema, COUNT(i.estudiante_id) AS total_alumnos, p.fecha_inicio, p.fecha_fin FROM inscripciones i
                                INNER JOIN estudiantes e ON i.estudiante_id = e.id
                                INNER JOIN clases c ON i.clase_id = c.id
                                INNER JOIN asignaturas a ON c.asignatura_id = a.id
                                INNER JOIN sistemas s ON c.sistema_id = s.id
                                INNER JOIN periodos p ON c.periodo_id = p.id
                                WHERE i.status = 1
                                GROUP BY i.clase_id");

    while ($dato = $mysqli->fetch_object()) {

        $mes_anio_inicio = ucfirst(strftime('%B %Y', strtotime($dato->fecha_inicio)));
        $mes_anio_fin = ucfirst(strftime('%B %Y', strtotime($dato->fecha_fin)));

        $datos[] = [
            "clase_id" => $dato->clase_id,
            "nombre_asignatura" => $dato->nombre_asignatura,
            "carrera_id" => $dato->carrera_id,
            "semestre_id" => $dato->semestre_id,
            "nombre_sistema" => $dato->nombre_sistema,
            "total_alumnos" => $dato->total_alumnos,
            "periodo" => $mes_anio_inicio . " - " . $mes_anio_fin
        ];
    }

    $mysqli->free_result();
    $conexion->close();

    print_r(json_encode($datos, JSON_UNESCAPED_UNICODE));
}
