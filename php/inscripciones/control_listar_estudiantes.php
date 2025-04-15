<?php

if (isset($_GET)) {

    if (!empty($_GET["clase_id"])) {
        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $clase_id = $_GET["clase_id"];

        $datos = array();

        $mysqli = $conexion->query("SELECT i.id, e.matricula, e.nombre, e.apellido_pa, e.apellido_ma, i.status FROM inscripciones i
                                    INNER JOIN estudiantes e ON i.estudiante_id = e.id
                                    WHERE i.clase_id = $clase_id
                                    ORDER BY e.apellido_pa");

        while ($dato = $mysqli->fetch_object()) {

            $datos[] = [
                "id" => $dato->id,
                "matricula" => $dato->matricula,
                "nombre_estudiante" => $dato->nombre . " " . $dato->apellido_pa . " " . $dato->apellido_ma,
                "status" => $dato->status
            ];
        }

        $mysqli->free_result();
        $conexion->close();

        print_r(json_encode($datos, JSON_UNESCAPED_UNICODE));
    }
}
