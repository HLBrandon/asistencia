<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["id_url"]) and
        !empty($_POST["nombre_carrera"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $id_url = trim($_POST["id_url"]);
        $id = trim($_POST["id"]);
        $nombre_carrera = trim($_POST["nombre_carrera"]);

        // El ID existe, se procede con la actualización
        $mysqli = $conexion->prepare("UPDATE carreras SET nombre_carrera = ?, id = ? WHERE id = ?");
        $mysqli->bind_param("sss", $nombre_carrera, $id, $id_url);
        $mysqli->execute();

        $response = [
            "status" => true,
            "titulo" => "Actualización exitosa",
            "texto" => "La carrera fue actualizada con éxito",
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
