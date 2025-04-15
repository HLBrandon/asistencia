<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["fecha_inicio"]) and
        !empty($_POST["fecha_fin"]) and
        isset($_POST["activo"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $id = trim($_POST["id"]);
        $fecha_inicio = trim($_POST["fecha_inicio"]);
        $fecha_fin = trim($_POST["fecha_fin"]);
        $activo = trim($_POST["activo"]);

        // El ID existe, se procede con la actualización
        $mysqli = $conexion->prepare("UPDATE periodos SET fecha_inicio = ?, fecha_fin = ?, activo = ? WHERE id = ?");
        $mysqli->bind_param("ssii", $fecha_inicio, $fecha_fin, $activo, $id);
        $mysqli->execute();

        $response = [
            "status" => true,
            "titulo" => "Actualización exitosa",
            "texto" => "El periodo fue actualizado con éxito",
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
