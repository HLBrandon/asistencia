<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["nombre"]) and
        !empty($_POST["apellido_paterno"]) and
        !empty($_POST["apellido_materno"]) and
        !empty($_POST["correo"]) and
        !empty($_POST["contrasenia"]) and
        !empty($_POST["role_id"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $nombre = $_POST["nombre"];
        $apellido_paterno = trim($_POST["apellido_paterno"]);
        $apellido_materno = trim($_POST["apellido_materno"]);
        $correo = trim($_POST["correo"]);
        $contrasenia = password_hash(trim($_POST["contrasenia"]), PASSWORD_DEFAULT);
        $role_id = $_POST["role_id"];

        $mysqli = $conexion->prepare("INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, correo, contrasenia, role_id) VALUES (?, ?, ?, ?, ?, ?)");
        $mysqli->bind_param("sssssi", $nombre, $apellido_paterno, $apellido_materno, $correo, $contrasenia, $role_id);
        $mysqli->execute();

        $conexion->close();
        $mysqli->close();

        $response = [
            "status" => true,
            "titulo" => "Registro exitoso",
            "texto" => "El usuario fue creado con exito",
            "icono" => "success"
        ];
    } else {
        $response = [
            "status" => false,
            "titulo" => "Campos vacios",
            "texto" => "Debes completar todo el formulario",
            "icono" => "error"
        ];
    }

    print_r(json_encode($response, JSON_UNESCAPED_UNICODE));
}
