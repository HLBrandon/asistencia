<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["nombre"]) and
        !empty($_POST["apellido_paterno"]) and
        !empty($_POST["apellido_materno"]) and
        !empty($_POST["correo"]) and
        !empty($_POST["role_id"])
    ) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $apellido_paterno = trim($_POST["apellido_paterno"]);
        $apellido_materno = trim($_POST["apellido_materno"]);
        $correo = trim($_POST["correo"]);
        $contrasenia = password_hash(trim($_POST["contrasenia"]), PASSWORD_DEFAULT);
        $role_id = $_POST["role_id"];

        $sql = "UPDATE usuarios SET nombre = ?, apellido_paterno = ?, apellido_materno = ?, correo = ?, role_id = ? WHERE id = ?";

        if (!empty($_POST["contrasenia"])) {
            $sql = "UPDATE usuarios SET nombre = ?, apellido_paterno = ?, apellido_materno = ?, correo = ?, contrasenia = ?, role_id = ? WHERE id = ?";
            $mysqli = $conexion->prepare($sql);
            $mysqli->bind_param("sssssis", $nombre, $apellido_paterno, $apellido_materno, $correo, $contrasenia, $role_id, $id);
            $mysqli->execute();
        } else {
            $mysqli = $conexion->prepare($sql);
            $mysqli->bind_param("ssssii", $nombre, $apellido_paterno, $apellido_materno, $correo, $role_id, $id);
            $mysqli->execute();
        }

        $conexion->close();
        $mysqli->close();

        $response = [
            "status" => true,
            "titulo" => "Actualización exitosa",
            "texto" => "El usuario fue actualizado con éxito",
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
?>
