<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["clase_id"]) and
        !empty($_POST["estudiante_id"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $id = $_POST["id"];
        $clase_id = $_POST["clase_id"];
        $estudiante_id = $_POST["estudiante_id"];

        // Actualizar la inscripción
        $mysqli = $conexion->prepare("UPDATE inscripciones SET clase_id = ?, estudiante_id = ? WHERE id = ?");
        $mysqli->bind_param("iii", $clase_id, $estudiante_id, $id);
        $mysqli->execute();

        $mysqli->close();
        $conexion->close();

        $response = [
            "status" => true,
            "titulo" => "Actualización exitosa",
            "texto" => "La inscripción fue actualizada con éxito",
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
