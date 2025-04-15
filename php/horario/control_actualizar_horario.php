<?php

if (!empty($_POST)) {

    if (!empty($_POST['dia_id']) && !empty($_POST['hora_inicio']) && !empty($_POST['hora_fin']) && !empty($_POST['horario_id'])) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $dia_id = trim($_POST['dia_id']);
        $hora_inicio = trim($_POST['hora_inicio']);
        $hora_fin = trim($_POST['hora_fin']);
        $horario_id = trim($_POST['horario_id']);

        $stmt = $conexion->prepare("UPDATE horario SET dia_id = ?, hora_inicio = ?, hora_fin = ? WHERE id = ?");
        $stmt->bind_param("issi", $dia_id, $hora_inicio, $hora_fin, $horario_id);
        $stmt->execute();

        $stmt->close();
        $conexion->close();

        $response = [
            "status" => true,
            "titulo" => "Actualización exitosa",
            "texto" => "El horario fue actualizado con éxito",
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