<?php

session_start();

require_once __DIR__ . "/../../admin/conexion.php";

// Verificar que la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: registro.html");
    exit;
}

// Obtener los datos del formulario
$nombre = trim($_POST["nombre"] ?? "");
$apellidos = trim($_POST["apellidos"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$contrasena = $_POST["contrasena"] ?? "";
$confirmar = $_POST["confirmar_contrasena"] ?? "";

// Validar campos obligatorios
if (
    empty($nombre) ||
    empty($apellidos) ||
    empty($correo) ||
    empty($contrasena) ||
    empty($confirmar)
) {
    header("Location: registro.html?error=campos");
    exit;
}

// Validar formato del correo
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header("Location: registro.html?error=correo");
    exit;
}

// Validar longitud de contraseña
if (strlen($contrasena) < 8) {
    header("Location: registro.html?error=contrasena");
    exit;
}

// Confirmar que las contraseñas coincidan
if ($contrasena !== $confirmar) {
    header("Location: registro.html?error=coincidencia");
    exit;
}

// Comprobar si el correo ya está registrado
$sql = "SELECT id_usuario FROM usuarios WHERE correo = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $stmt->close();
    $conexion->close();

    header("Location: registro.html?error=existe");
    exit;
}

$stmt->close();

// Crear hash seguro de la contraseña
$hash = password_hash($contrasena, PASSWORD_DEFAULT);

// Registrar al usuario con rol de cliente
$sql = "INSERT INTO usuarios
        (nombre, apellidos, correo, telefono, contrasena, rol)
        VALUES (?, ?, ?, ?, ?, 'cliente')";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "sssss",
    $nombre,
    $apellidos,
    $correo,
    $telefono,
    $hash
);

if ($stmt->execute()) {

    $stmt->close();
    $conexion->close();

    header("Location: login.html?registro=exitoso");
    exit;

} else {

    $stmt->close();
    $conexion->close();

    header("Location: registro.html?error=registro");
    exit;
}

?>
