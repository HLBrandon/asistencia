<?php

include_once __DIR__ . "../../../config/config.php";

session_unset();
// unset($_SESSION["usuario"]); es para destruir una sesion en especifico
session_destroy();

header("Location: " . URL_RAIZ);
