<?php
if (!empty($_POST)) {

    if (
        !empty($_POST["id"]) and
        !empty($_POST["contrasenia"]) and
        !empty($_POST["contrasenia_nueva"]) and
        !empty($_POST["contrasenia_confirmar"])
    ) {

        $id = $_POST["id"];
        $contrasenia = trim($_POST["contrasenia"]);
        $contrasenia_nueva = trim($_POST["contrasenia_nueva"]);
        $contrasenia_confirmar = trim($_POST["contrasenia_confirmar"]);

        if ($contrasenia_nueva == $contrasenia_confirmar) {

            require_once __DIR__ . "../../../config/config.php";
            require_once __DIR__ . "../../conexion.php";

            $stmt = $conexion->prepare("SELECT contrasenia FROM usuarios WHERE id = ? AND activo = 1 LIMIT 1");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($contrasenia, $hashed_password)) {

                $nuevo_hash = password_hash($contrasenia_nueva, PASSWORD_DEFAULT);
                $sql = "UPDATE usuarios SET contrasenia = ? WHERE id = ?";
                $mysqli = $conexion->prepare($sql);
                $mysqli->bind_param("si", $nuevo_hash, $id);
                $mysqli->execute();

                $response = [
                    "status" => true,
                    "titulo" => "Cambio exitoso",
                    "texto" => "Tu contraseña se actualizó con exito",
                    "icono" => "success"
                ];
            } else {
                $response = [
                    "status" => false,
                    "titulo" => "Actual Contraseña incorrecta",
                    "texto" => "Actual contraseña que has ingresado es incorrecta",
                    "icono" => "error"
                ];
            }

            $mysqli->close();
            $stmt->close();
            $conexion->close();
        } else {
            $response = [
                "status" => false,
                "titulo" => "Contraseñas no coinciden",
                "texto" => "Nueva Contraseña y Confirmar Contraseña no coinciden",
                "icono" => "error"
            ];
        }
    } else {
        $response = [
            "status" => false,
            "titulo" => "Campos vacios",
            "texto" => "Debes completar todo el formulario Cambiar mi contraseña",
            "icono" => "error"
        ];
    }

    print_r(json_encode($response, JSON_UNESCAPED_UNICODE));
}
