<?php

if (isset($_POST)) {

    if (!empty($_POST["carrera_id"]) && !empty($_POST["semestre_id"]) && !empty($_POST["sistema_id"])) {
        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $carrera_id = $_POST["carrera_id"];
        $semestre_id = $_POST["semestre_id"];
        $sistema_id = $_POST["sistema_id"];

        $datos = array();

        $mysqli = $conexion->query("SELECT id, nombre, apellido_pa, apellido_ma FROM estudiantes 
                                    WHERE
                                        carrera_id = '$carrera_id' AND
                                        semestre_id = $semestre_id AND
                                        sistema_id = $sistema_id
                                    ORDER BY apellido_pa");

        while ($dato = $mysqli->fetch_object()) {

            $datos[] = [
                "id" => $dato->id,
                "nombre_estudiante" => $dato->nombre . " " . $dato->apellido_pa . " " . $dato->apellido_ma
            ];

        }

        $mysqli->free_result();
        $conexion->close();

        print_r(json_encode($datos, JSON_UNESCAPED_UNICODE));
    }
}
