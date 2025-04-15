<?php

if (!empty($_POST)) {

    if (!empty($_POST["email"]) && !empty($_POST["password"])) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";

        $correo = trim($_POST["email"]);
        $contrasenia = trim($_POST["password"]);

        $stmt = $conexion->prepare("SELECT id, nombre, apellido_paterno, apellido_materno, correo, contrasenia, role_id FROM usuarios WHERE correo = ? AND activo = 1 LIMIT 1");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $nombre, $apellido_paterno, $apellido_materno, $correo, $hashed_password, $role_id);
            $stmt->fetch();

            if (password_verify($contrasenia, $hashed_password)) {
                $_SESSION["usuario"] = [
                    "id" => $id,
                    "nombre" => $nombre,
                    "apellido_paterno" => $apellido_paterno,
                    "apellido_materno" => $apellido_materno,
                    "correo" => $correo,
                    "role_id" => $role_id
                ];
                $response = [
                    "status" => true,
                    "titulo" => "Inicio de sesión exitoso",
                    "texto" => "Bienvenido, $nombre",
                    "icono" => "success"
                ];
            } else {
                $response = [
                    "status" => false,
                    "titulo" => "Contraseña incorrecta",
                    "texto" => "La contraseña que has ingresado es incorrecta",
                    "icono" => "error"
                ];
            }

        } else {
            $response = [
                "status" => false,
                "titulo" => "Usuario no encontrado",
                "texto" => "El correo ingresado no está registrado o el usuario no está activo",
                "icono" => "error"
            ];
        }

        $stmt->close();
        $conexion->close();
    } else {
        $response = [
            "status" => false,
            "titulo" => "Campos vacíos",
            "texto" => "Debes completar ambos campos: correo y contraseña",
            "icono" => "error"
        ];
    }

    print_r(json_encode($response, JSON_UNESCAPED_UNICODE));
}
