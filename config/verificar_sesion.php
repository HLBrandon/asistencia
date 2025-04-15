<?php

# VERIFICA SI HAY UNA SESION
if (!empty($_SESSION["usuario"])) {
    header("Location: " . URL_RAIZ . "view/home"); // SI HAY SESION TE ENVIA AL HOME
}