
<?php

session_start();

require_once __DIR__ . "/../../admin/conexion.php";

// Verificar que el formulario se haya enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.html");
    exit;
}

// Obtener los datos del formulario
$correo = trim($_POST["correo"] ?? "");
$contrasena = $_POST["contrasena"] ?? "";

if (empty($correo) || empty($contrasena)) {
    header("Location: login.html?error=campos");
    exit;
}

// Buscar el usuario por su correo electrónico
$sql = "SELECT id_usuario, nombre, apellidos, correo, contrasena, rol
        FROM usuarios
        WHERE correo = ?";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta.");
}

$stmt->bind_param("s", $correo);
$stmt->execute();

$resultado = $stmt->get_result();

// Verificar las credenciales
if ($usuario = $resultado->fetch_assoc()) {

    if (password_verify($contrasena, $usuario["contrasena"])) {

        // Regenerar el identificador de sesión
        session_regenerate_id(true);

        // Guardar los datos del usuario
        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nombre"] = $usuario["nombre"];
        $_SESSION["apellidos"] = $usuario["apellidos"];
        $_SESSION["correo"] = $usuario["correo"];
        $_SESSION["rol"] = $usuario["rol"];

        $stmt->close();
        $conexion->close();

        // Redirigir según el rol
        switch ($usuario["rol"]) {
            case "admin":
                header("Location: ../../admin/index.php");
                break;

            case "empleado":
                header("Location: empleado.php");
                break;

            case "cliente":
                header("Location: cliente.php");
                break;

            default:
                session_destroy();
                header("Location: login.html?error=rol");
                break;
        }

        exit;
    }
}

// Si las credenciales son incorrectas
$stmt->close();
$conexion->close();

header("Location: login.html?error=credenciales");
exit;

?>
