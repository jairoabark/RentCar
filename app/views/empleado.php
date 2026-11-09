<?php
session_start();

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== "empleado") {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del empleado | Ruta Tica Rent a Car</title>

    <link rel="stylesheet" href="../../public/css/diseno.css">
</head>

<body>

    <div class="container">

        <header class="site-header">
            <div class="container-inner">
                <h1 class="logo">Ruta Tica Rent a Car</h1>

                <nav class="main-nav">
                    <ul>
                        <li><a href="../../inicio.html">Inicio</a></li>
                        <li><a href="../../catalogo.html">Catálogo de Vehículos</a></li>
                        <li>
                            <a href="../../admin/reservas.php">Gestión de reservas</a>
                        </li>
                        <li>
                            <a href="cerrar_sesion.php" class="btn btn-sesion">
                                Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="contenido">

            <section>
                <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION["nombre"]); ?></h2>

                <p>
                    Desde este espacio puedes acceder a las funciones
                    de atención y gestión de reservaciones.
                </p>

                <a href="../../admin/reservas.php" class="btn">
                    Gestionar reservas
                </a>

                <a href="../../catalogo.html" class="btn btn-secundario">
                    Consultar vehículos
                </a>
            </section>

        </main>

        <footer class="site-footer">
            <div class="container-inner">
                <p>© 2026 Ruta Tica</p>
            </div>
        </footer>

    </div>

</body>
</html>