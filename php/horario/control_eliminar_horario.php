<?php

if (!empty($_POST)) {

    if (isset($_POST['horario_id'])) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $horario_id = $_POST['horario_id'];

        $stmt = $conexion->prepare("DELETE FROM horario WHERE id = ?");
        $stmt->bind_param("i", $horario_id);
        $stmt->execute();

        $stmt->close();
        $conexion->close(); 

        $response = [
            "status" => true,
            "titulo" => "Eliminado",
            "texto" => "El horario fue eliminado con éxito",
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
