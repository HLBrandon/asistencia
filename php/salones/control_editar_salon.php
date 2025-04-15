<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["id_url"]) and
        !empty($_POST["nombre_salon"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $id_url = trim($_POST["id_url"]);
        $id = trim($_POST["id"]);
        $nombre_salon = trim($_POST["nombre_salon"]);

        // El ID existe, se procede con la actualización
        $mysqli = $conexion->prepare("UPDATE salones SET nombre_salon = ?, id = ? WHERE id = ?");
        $mysqli->bind_param("sss", $nombre_salon, $id, $id_url);
        $mysqli->execute();

        $response = [
            "status" => true,
            "titulo" => "Actualización exitosa",
            "texto" => "El salón fue actualizado con éxito",
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
