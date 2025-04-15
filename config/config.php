<?php
session_start(); // Se comienza una sesión

# Zona horaria
date_default_timezone_set('America/Mexico_City');
# establecer el español como idioma
setlocale(LC_TIME, 'spanish');

#Ruta raiz
define('URL_RAIZ', 'http://localhost/asistencia/');
define('SIGLAS', 'ITSMT');

# Conexion a la base de datos
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');
define('DB_NAME', 'asistencia_app');
define('PUERTO', '3306');