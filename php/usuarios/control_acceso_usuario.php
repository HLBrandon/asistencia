<?php

if (!empty($_POST)) {

    if (!empty($_POST["usuario_id"])) {

        require_once __DIR__ . "../../../config/config.php";
        require_once __DIR__ . "../../conexion.php";
        $id = $_POST["usuario_id"];

        $mysqli = $conexion->prepare("SELECT activo FROM usuarios WHERE id = ? LIMIT 1");
        $mysqli->bind_param("s", $id);
        $mysqli->execute();
        $result = $mysqli->get_result();
        $dato = $result->fetch_object()->activo;

        if ($dato == 1) {
            updated($id, 0, $conexion);
            $repuesta = [
                "titulo" => "Acceso Denegado",
                "texto"  => "El usuario perdio el acceso al sistema",
                "icono"  => "success"
            ];
        } else {
            updated($id, 1, $conexion);
            $repuesta = [
                "titulo" => "Acceso Concedido",
                "texto"  => "El usuario tiene el acceso al sistema",
                "icono"  => "success"
            ];
        }

        $mysqli->close();
        $conexion->close();

        print_r(json_encode($repuesta, JSON_UNESCAPED_UNICODE));
    }
}

function updated($id, $status, $conn)
{
    $updated = $conn->prepare("UPDATE usuarios SET activo = ? WHERE id = ?");
    $updated->bind_param("ii", $status, $id);
    $updated->execute();
}
