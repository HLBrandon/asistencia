<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["nombre_id"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $nombre_id = trim($_POST["nombre_id"]);

        // Verificar si el nombre ya existe
        $stmt = $conexion->prepare("SELECT id FROM dias WHERE nombre_id = ?");
        $stmt->bind_param("s", $nombre_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = [
                "status" => false,
                "titulo" => "Nombre duplicado",
                "texto" => "El nombre del día ya existe",
                "icono" => "error"
            ];
        } else {
            $mysqli = $conexion->prepare("INSERT INTO dias (nombre_id) VALUES (?)");
            $mysqli->bind_param("s", $nombre_id);
            $mysqli->execute();

            $mysqli->close();

            $response = [
                "status" => true,
                "titulo" => "Registro exitoso",
                "texto" => "El día fue creado con éxito",
                "icono" => "success"
            ];
        }

        $stmt->close();
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
