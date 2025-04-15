<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["nombre_semestre"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $id = trim($_POST["id"]);
        $nombre_semestre = trim($_POST["nombre_semestre"]);

        // El ID existe, se procede con la actualización
        $mysqli = $conexion->prepare("UPDATE semestres SET nombre_semestre = ? WHERE id = ?");
        $mysqli->bind_param("si", $nombre_semestre, $id);
        $mysqli->execute();

        $response = [
            "status" => true,
            "titulo" => "Actualización exitosa",
            "texto" => "El semestre fue actualizado con éxito",
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
