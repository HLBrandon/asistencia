<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["nombre"]) and
        !empty($_POST["apellido_paterno"]) and
        !empty($_POST["apellido_materno"]) and
        !empty($_POST["correo"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $id = $_POST["id"];
        $nombre = trim($_POST["nombre"]);
        $apellido_paterno = trim($_POST["apellido_paterno"]);
        $apellido_materno = trim($_POST["apellido_materno"]);
        $correo = trim($_POST["correo"]);

        $mysqli = $conexion->prepare("UPDATE usuarios SET nombre = ?, apellido_paterno = ?, apellido_materno = ?, correo = ? WHERE id = ?");
        $mysqli->bind_param("ssssi", $nombre, $apellido_paterno, $apellido_materno, $correo, $id);
        $mysqli->execute();

        $conexion->close();
        $mysqli->close();

        $_SESSION["usuario"]["nombre"] = $nombre;
        $_SESSION["usuario"]["apellido_paterno"] = $apellido_paterno;
        $_SESSION["usuario"]["apellido_materno"] = $apellido_materno;
        $_SESSION["usuario"]["correo"] = $correo;

        $response = [
            "status" => true,
            "titulo" => "Exitoso",
            "texto" => "Tu información se modificó con exito.",
            "icono" => "success"
        ];

    } else {
        $response = [
            "status" => false,
            "titulo" => "Campos vacios",
            "texto" => "Debes completar todo el formulario Mi Información",
            "icono" => "error"
        ];
    }

    print_r(json_encode($response, JSON_UNESCAPED_UNICODE));
}
