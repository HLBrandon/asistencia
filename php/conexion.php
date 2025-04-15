<?php

$conexion = new mysqli(HOST, USER, PASSWORD, DB_NAME, PUERTO);

if ($conexion->connect_errno) {
    print_r("Error de conexion: " . $conexion->connect_error);
    exit;
}
