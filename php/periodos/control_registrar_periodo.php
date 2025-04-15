<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["fecha_inicio"]) and
        !empty($_POST["fecha_fin"]) and
        isset($_POST["activo"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $fecha_inicio = trim($_POST["fecha_inicio"]);
        $fecha_fin = trim($_POST["fecha_fin"]);
        $activo = trim($_POST["activo"]);

        // Verificar si el periodo ya existe
        $stmt = $conexion->prepare("SELECT id FROM periodos WHERE fecha_inicio = ? AND fecha_fin = ?");
        $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = [
                "status" => false,
                "titulo" => "Periodo duplicado",
                "texto" => "El periodo ya existe",
                "icono" => "error"
            ];
        } else {
            $mysqli = $conexion->prepare("INSERT INTO periodos (fecha_inicio, fecha_fin, activo) VALUES (?, ?, ?)");
            $mysqli->bind_param("ssi", $fecha_inicio, $fecha_fin, $activo);
            $mysqli->execute();

            $mysqli->close();

            $response = [
                "status" => true,
                "titulo" => "Registro exitoso",
                "texto" => "El periodo fue creado con éxito",
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
