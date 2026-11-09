
<?php
require_once "conexion.php";

// Consultar usuarios registrados
$sql = "SELECT id_usuario, nombre, apellidos, correo, telefono, rol, fecha_registro
        FROM usuarios
        ORDER BY id_usuario DESC";

$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error al consultar usuarios: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestión de usuarios | Ruta Tica Rent a Car</title>

    <link rel="stylesheet" href="../css/estilos-admin.css">
</head>

<body>

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
                        <a href="index.php">Panel principal</a>
                    </li>

                    <li>
                        <a href="usuarios.php" class="activo">
                            Gestión de usuarios
                        </a>
                    </li>

                    <li>
                        <a href="reservas.php">Gestión de reservas</a>
                    </li>

                    <li>
                        <a href="pagos.php">Gestión de pagos</a>
                    </li>
                </ul>
            </nav>

        </aside>

        <!-- Contenido principal -->
        <main class="contenido">

            <header class="encabezado">

                <div>
                    <h1>Gestión de usuarios</h1>
                    <p>Administración de los usuarios registrados en el sistema.</p>
                </div>

                <div class="administrador">
                    <span>Administrador</span>
                </div>

            </header>

            <!-- Tabla de usuarios -->
            <section class="seccion-informacion">

                <h2>Usuarios del sistema</h2>

                <p>
                    Total de usuarios registrados:
                    <strong><?php echo $resultado->num_rows; ?></strong>
                </p>

                <div class="tabla-contenedor">

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Rol</th>
                                <th>Fecha de registro</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if ($resultado->num_rows > 0): ?>

                                <?php while ($usuario = $resultado->fetch_assoc()): ?>

                                    <tr>
                                        <td>
                                            <?php echo htmlspecialchars($usuario["id_usuario"]); ?>
                                        </td>

                                        <td>
                                            <?php
                                            echo htmlspecialchars(
                                                $usuario["nombre"] . " " . $usuario["apellidos"]
                                            );
                                            ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($usuario["correo"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($usuario["telefono"] ?? ""); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($usuario["rol"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($usuario["fecha_registro"]); ?>
                                        </td>
                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="6">
                                        No hay usuarios registrados en la base de datos.
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>
                    </table>

                </div>

            </section>

            <footer class="pie-pagina">
                <p>Ruta Tica Rent a Car | Gestión de usuarios</p>
            </footer>

        </main>

    </div>

</body>
</html>
