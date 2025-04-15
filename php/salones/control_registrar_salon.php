<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["nombre_salon"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $id = trim($_POST["id"]);
        $nombre_salon = trim($_POST["nombre_salon"]);

        // Verificar si el id ya existe
        $stmt = $conexion->prepare("SELECT id FROM salones WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = [
                "status" => false,
                "titulo" => "ID duplicado",
                "texto" => "El ID del salón ya existe",
                "icono" => "error"
            ];
        } else {
            $mysqli = $conexion->prepare("INSERT INTO salones (id, nombre_salon) VALUES (?, ?)");
            $mysqli->bind_param("ss", $id, $nombre_salon);
            $mysqli->execute();

            $mysqli->close();

            $response = [
                "status" => true,
                "titulo" => "Registro exitoso",
                "texto" => "El salón fue creado con éxito",
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
?>
