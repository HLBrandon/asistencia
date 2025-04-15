<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["nombre_asignatura"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $id = trim($_POST["id"]);
        $nombre_asignatura = trim($_POST["nombre_asignatura"]);

        // Verificar si el id ya existe
        $stmt = $conexion->prepare("SELECT id FROM asignaturas WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = [
                "status" => false,
                "titulo" => "ID duplicado",
                "texto" => "El ID de la asignatura ya existe",
                "icono" => "error"
            ];
        } else {
            $mysqli = $conexion->prepare("INSERT INTO asignaturas (id, nombre_asignatura) VALUES (?, ?)");
            $mysqli->bind_param("ss", $id, $nombre_asignatura);
            $mysqli->execute();

            $mysqli->close();

            $response = [
                "status" => true,
                "titulo" => "Registro exitoso",
                "texto" => "La asignatura fue creada con éxito",
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
