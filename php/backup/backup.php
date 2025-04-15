<?php

require_once __DIR__ . "../../../config/config.php";

# VERIFICA SI NO HAY UNA SESION
if (empty($_SESSION["usuario"])) {
    header("Location: " . URL_RAIZ); // sI NO HAY SESION TE ENVIA AL LOGIN
    exit;
}

if ($_SESSION["usuario"]["role_id"] != 1) {
    echo "<h1>No tiene permisos</h1>";
    exit;
}

$db_name = DB_NAME;

$backup_file = 'backup_' . date('d-m-Y_H.i') . '.sql';

$comando = "mysqldump -u root -h localhost --add-drop-database --databases --routines $db_name>$backup_file";

exec($comando);

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . basename($backup_file) . "\"");
readfile($backup_file);
exit;