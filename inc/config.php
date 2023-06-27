<?php
// Datos de configuración de la base de datos
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "recepcion-utiles");

// Constantes globales
define("SITENAME", "#BSJC");
define("DESCRIPTION", "Recepción de utiles escolares");
define("URL", "http://localhost/recepcion-utiles/");

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}
