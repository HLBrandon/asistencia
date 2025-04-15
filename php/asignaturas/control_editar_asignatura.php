<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["id_url"]) and
        !empty($_POST["nombre_asignatura"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $id_url = trim($_POST["id_url"]);
        $id = trim($_POST["id"]);
        $nombre_asignatura = trim($_POST["nombre_asignatura"]);

        // El ID existe, se procede con la actualización
        $mysqli = $conexion->prepare("UPDATE asignaturas SET nombre_asignatura = ?, id = ? WHERE id = ?");
        $mysqli->bind_param("sss", $nombre_asignatura, $id, $id_url);
        $mysqli->execute();

        $response = [
            "status" => true,
            "titulo" => "Actualización exitosa",
            "texto" => "La asignatura fue actualizada con éxito",
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
