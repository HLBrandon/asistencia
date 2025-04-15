<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["profesor_id"]) and
        !empty($_POST["asignatura_id"]) and
        !empty($_POST["carrera_id"]) and
        !empty($_POST["semestre_id"]) and
        !empty($_POST["sistema_id"]) and
        !empty($_POST["periodo_id"]) and
        !empty($_POST["salon_id"]) and
        isset($_POST["activo"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $id = $_POST["id"];
        $profesor_id = $_POST["profesor_id"];
        $asignatura_id = $_POST["asignatura_id"];
        $carrera_id = $_POST["carrera_id"];
        $semestre_id = $_POST["semestre_id"];
        $sistema_id = $_POST["sistema_id"];
        $periodo_id = $_POST["periodo_id"];
        $salon_id = $_POST["salon_id"];
        $activo = $_POST["activo"];

        // Actualizar la clase
        $mysqli = $conexion->prepare("UPDATE clases SET profesor_id = ?, asignatura_id = ?, carrera_id = ?, semestre_id = ?, sistema_id = ?, periodo_id = ?, salon_id = ?, activo = ? WHERE id = ?");
        $mysqli->bind_param("issiiisii", $profesor_id, $asignatura_id, $carrera_id, $semestre_id, $sistema_id, $periodo_id, $salon_id, $activo, $id);
        $mysqli->execute();

        $mysqli->close();
        $conexion->close();

        $response = [
            "status" => true,
            "titulo" => "Actualización exitosa",
            "texto" => "La clase fue actualizada con éxito",
            "icono" => "success"
        ];
    } else {
        $response = [
            "status" => false,
            "titulo" => "Campos vacíos",
            "texto" => "Debes completar todo el formulario",
            "icono" => "error"
        ];
    }

    print_r(json_encode($response, JSON_UNESCAPED_UNICODE));
}
