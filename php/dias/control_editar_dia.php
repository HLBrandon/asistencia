<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["nombre_id"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $id = trim($_POST["id"]);
        $nombre_id = trim($_POST["nombre_id"]);

        // El ID existe, se procede con la actualización
        $mysqli = $conexion->prepare("UPDATE dias SET nombre_id = ? WHERE id = ?");
        $mysqli->bind_param("si", $nombre_id, $id);
        $mysqli->execute();

        $response = [
            "status" => true,
            "titulo" => "Actualización exitosa",
            "texto" => "El día fue actualizado con éxito",
            "icono" => "success"
        ];

        $mysqli->close();
        $conexion->close();
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
