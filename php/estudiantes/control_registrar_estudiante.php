<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["matricula"]) and
        !empty($_POST["nombre"]) and
        !empty($_POST["apellido_pa"]) and
        !empty($_POST["apellido_ma"]) and
        !empty($_POST["carrera_id"]) and
        !empty($_POST["semestre_id"]) and
        !empty($_POST["sistema_id"]) and
        isset($_POST["activo"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $matricula = trim($_POST["matricula"]);
        $nombre = $_POST["nombre"];
        $apellido_pa = trim($_POST["apellido_pa"]);
        $apellido_ma = trim($_POST["apellido_ma"]);
        $carrera_id = $_POST["carrera_id"];
        $semestre_id = $_POST["semestre_id"];
        $sistema_id = $_POST["sistema_id"];
        $activo = $_POST["activo"];

        // Verificar si la matrícula ya existe
        $stmt = $conexion->prepare("SELECT id FROM estudiantes WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = [
                "status" => false,
                "titulo" => "Matrícula duplicada",
                "texto" => "La matrícula ya está registrada",
                "icono" => "error"
            ];
        } else {
            $mysqli = $conexion->prepare("INSERT INTO estudiantes (matricula, nombre, apellido_pa, apellido_ma, carrera_id, semestre_id, sistema_id, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $mysqli->bind_param("sssssiis", $matricula, $nombre, $apellido_pa, $apellido_ma, $carrera_id, $semestre_id, $sistema_id, $activo);
            $mysqli->execute();

            $mysqli->close();

            $response = [
                "status" => true,
                "titulo" => "Registro exitoso",
                "texto" => "El estudiante fue creado con éxito",
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
