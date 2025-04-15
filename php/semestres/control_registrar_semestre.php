<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["nombre_semestre"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $nombre_semestre = trim($_POST["nombre_semestre"]);

        // Verificar si el nombre ya existe
        $stmt = $conexion->prepare("SELECT id FROM semestres WHERE nombre_semestre = ?");
        $stmt->bind_param("s", $nombre_semestre);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = [
                "status" => false,
                "titulo" => "Nombre duplicado",
                "texto" => "El nombre del semestre ya existe",
                "icono" => "error"
            ];
        } else {
            $mysqli = $conexion->prepare("INSERT INTO semestres (nombre_semestre) VALUES (?)");
            $mysqli->bind_param("s", $nombre_semestre);
            $mysqli->execute();

            $mysqli->close();

            $response = [
                "status" => true,
                "titulo" => "Registro exitoso",
                "texto" => "El semestre fue creado con éxito",
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
