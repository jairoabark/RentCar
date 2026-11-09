<?php
session_start();

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== "cliente") {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del cliente | Ruta Tica Rent a Car</title>

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
                        <li><a href="../../mis-reservas.html">Mis reservas</a></li>
                        <li><a href="cerrar_sesion.php" class="btn btn-sesion">Cerrar sesión</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="contenido">

            <section>
                <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION["nombre"]); ?></h2>

                <p>Desde aquí puedes consultar los vehículos disponibles y administrar tus reservaciones.</p>

                <a href="../../catalogo.html" class="btn">Explorar vehículos</a>

                <a href="../../mis-reservas.html" class="btn btn-secundario">Consultar mis reservas</a>
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