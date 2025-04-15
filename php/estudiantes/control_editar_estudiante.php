<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
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

        $id = $_POST["id"];
        $matricula = trim($_POST["matricula"]);
        $nombre = $_POST["nombre"];
        $apellido_pa = trim($_POST["apellido_pa"]);
        $apellido_ma = trim($_POST["apellido_ma"]);
        $carrera_id = $_POST["carrera_id"];
        $semestre_id = $_POST["semestre_id"];
        $sistema_id = $_POST["sistema_id"];
        $activo = $_POST["activo"];

        $sql = "UPDATE estudiantes SET matricula = ?, nombre = ?, apellido_pa = ?, apellido_ma = ?, carrera_id = ?, semestre_id = ?, sistema_id = ?, activo = ? WHERE id = ?";

        $mysqli = $conexion->prepare($sql);
        $mysqli->bind_param("sssssiisi", $matricula, $nombre, $apellido_pa, $apellido_ma, $carrera_id, $semestre_id, $sistema_id, $activo, $id);
        $mysqli->execute();

        $conexion->close();
        $mysqli->close();

        $response = [
            "status" => true,
            "titulo" => "Actualización exitosa",
            "texto" => "El estudiante fue actualizado con éxito",
            "icono" => "success"
        ];
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
