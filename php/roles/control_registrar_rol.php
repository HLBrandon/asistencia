<?php
if (!empty($_POST)) {

    if (!empty($_POST["nombre_role"])) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $nombre_role = trim($_POST["nombre_role"]);

        // Verificar si el nombre ya existe
        $stmt = $conexion->prepare("SELECT id FROM roles WHERE nombre_role = ?");
        $stmt->bind_param("s", $nombre_role);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = [
                "status" => false,
                "titulo" => "Nombre duplicado",
                "texto" => "El nombre del rol ya existe",
                "icono" => "error"
            ];
        } else {
            $mysqli = $conexion->prepare("INSERT INTO roles (nombre_role) VALUES (?)");
            $mysqli->bind_param("s", $nombre_role);
            $mysqli->execute();

            $mysqli->close();

            $response = [
                "status" => true,
                "titulo" => "Registro exitoso",
                "texto" => "El rol fue creado con éxito",
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
