<?php

if (!empty($_POST)) {

    if (!empty($_POST['dia_id']) && !empty($_POST['hora_inicio']) && !empty($_POST['hora_fin']) && !empty($_POST['clase_id'])) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $dia_id = trim($_POST['dia_id']);
        $hora_inicio = trim($_POST['hora_inicio']);
        $hora_fin = trim($_POST['hora_fin']);
        $clase_id = trim($_POST['clase_id']);

        $stmt = $conexion->prepare("INSERT INTO horario (clase_id, dia_id, hora_inicio, hora_fin) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $clase_id, $dia_id, $hora_inicio, $hora_fin);
        $stmt->execute();

        $stmt->close();
        $conexion->close();

        $response = [
            "status" => true,
            "titulo" => "Registro exitoso",
            "texto" => "El horario fue creado con éxito",
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
