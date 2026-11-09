
<?php
session_start();

// Verificar que el usuario haya iniciado sesión como administrador
if (
    !isset($_SESSION["id_usuario"]) ||
    $_SESSION["rol"] !== "admin"
) {
    header("Location: ../app/views/login.html");
    exit;
}

require_once "conexion.php";

// Total de usuarios registrados
$sql_usuarios = "SELECT COUNT(*) AS total FROM usuarios";
$resultado_usuarios = $conexion->query($sql_usuarios);

if (!$resultado_usuarios) {
    die("Error al consultar usuarios: " . $conexion->error);
}

$total_usuarios = $resultado_usuarios->fetch_assoc()["total"];

// Total de reservas realizadas
$sql_reservas = "SELECT COUNT(*) AS total FROM reservas";
$resultado_reservas = $conexion->query($sql_reservas);

if (!$resultado_reservas) {
    die("Error al consultar reservas: " . $conexion->error);
}

$total_reservas = $resultado_reservas->fetch_assoc()["total"];

// Total de reservas pendientes
$sql_pendientes = "SELECT COUNT(*) AS total
                   FROM reservas
                   WHERE estado = 'pendiente'";

$resultado_pendientes = $conexion->query($sql_pendientes);

if (!$resultado_pendientes) {
    die("Error al consultar reservas pendientes: " . $conexion->error);
}

$total_pendientes = $resultado_pendientes->fetch_assoc()["total"];

// Total de pagos registrados
$sql_pagos = "SELECT COUNT(*) AS total FROM pagos";
$resultado_pagos = $conexion->query($sql_pagos);

if (!$resultado_pagos) {
    die("Error al consultar pagos: " . $conexion->error);
}

$total_pagos = $resultado_pagos->fetch_assoc()["total"];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administración | Ruta Tica Rent a Car</title>

    <!-- Hoja de estilos del administrador -->
    <link rel="stylesheet" href="../css/estilos-admin.css">
</head>

<body>

    <!-- Contenedor principal -->
    <div class="contenedor">

        <!-- Menú lateral -->
        <aside class="menu-lateral">

            <div class="logo">
                <h2>Ruta Tica</h2>
                <p>Rent a Car</p>
            </div>

            <nav>
                <ul>
                    <li>
                        <a href="index.php" class="activo">
                            Panel principal
                        </a>
                    </li>

                    <li>
                        <a href="usuarios.php">
                            Gestión de usuarios
                        </a>
                    </li>

                    <li>
                        <a href="reservas.php">
                            Gestión de reservas
                        </a>
                    </li>

                    <li>
                        <a href="pagos.php">
                            Gestión de pagos
                        </a>
                    </li>
                </ul>
            </nav>

        </aside>

        <!-- Contenido principal -->
        <main class="contenido">

            <!-- Encabezado -->
            <header class="encabezado">

                <div>
                    <h1>Panel de Administración</h1>
                    <p>Bienvenido al sistema administrativo de Ruta Tica Rent a Car.</p>
                </div>

                <div class="administrador">
                    <span>
                        <?php echo htmlspecialchars($_SESSION["nombre"]); ?>
                    </span>

                    <a href="../app/views/cerrar_sesion.php">
                        Cerrar sesión
                    </a>
                </div>

            </header>

            <!-- Resumen del sistema -->
            <section class="resumen">

                <div class="tarjeta">
                    <h3>Usuarios registrados</h3>
                    <p class="numero">
                        <?php echo $total_usuarios; ?>
                    </p>
                    <span>Clientes del sistema</span>
                </div>

                <div class="tarjeta">
                    <h3>Reservas realizadas</h3>
                    <p class="numero">
                        <?php echo $total_reservas; ?>
                    </p>
                    <span>Total de reservaciones</span>
                </div>

                <div class="tarjeta">
                    <h3>Reservas pendientes</h3>
                    <p class="numero">
                        <?php echo $total_pendientes; ?>
                    </p>
                    <span>Por gestionar</span>
                </div>

                <div class="tarjeta">
                    <h3>Pagos registrados</h3>
                    <p class="numero">
                        <?php echo $total_pagos; ?>
                    </p>
                    <span>Transacciones del sistema</span>
                </div>

            </section>

            <!-- Información administrativa -->
            <section class="seccion-informacion">

                <h2>Administración del sistema</h2>

                <p>
                    Desde este panel podrá gestionar los usuarios,
                    las reservaciones y los pagos asociados al servicio
                    de alquiler de vehículos.
                </p>

            </section>

            <!-- Accesos rápidos -->
            <section class="accesos">

                <h2>Accesos rápidos</h2>

                <div class="accesos-contenedor">

                    <a href="usuarios.php" class="acceso">
                        <h3>Usuarios</h3>
                        <p>Administrar los usuarios registrados.</p>
                    </a>

                    <a href="reservas.php" class="acceso">
                        <h3>Reservas</h3>
                        <p>Consultar y gestionar reservaciones.</p>
                    </a>

                    <a href="pagos.php" class="acceso">
                        <h3>Pagos</h3>
                        <p>Consultar los pagos realizados.</p>
                    </a>

                </div>

            </section>

            <!-- Pie de página -->
            <footer class="pie-pagina">

                <p>
                    Ruta Tica Rent a Car |
                    Panel administrativo
                </p>

            </footer>

        </main>

    </div>

</body>
</html>
