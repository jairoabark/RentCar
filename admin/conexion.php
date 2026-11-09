<?php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "ruta_tica_rent_car";

$conexion = new mysqli(
    $host,
    $usuario,
    $contrasena,
    $base_datos
);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");

?>