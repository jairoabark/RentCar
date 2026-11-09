
<?php
require_once "conexion.php";

// Consultar reservas y datos del cliente
$sql = "SELECT
            r.id_reserva,
            u.nombre,
            u.apellidos,
            u.correo,
            r.vehiculo,
            r.fecha_inicio,
            r.fecha_fin,
            r.lugar_entrega,
            r.lugar_devolucion,
            r.estado,
            r.precio_total
        FROM reservas r
        INNER JOIN usuarios u ON r.id_usuario = u.id_usuario
        ORDER BY r.id_reserva DESC";

$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error al consultar reservas: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestión de reservas | Ruta Tica Rent a Car</title>

    <link rel="stylesheet" href="../css/estilos-admin.css">
</head>

<body>

    <div class="contenedor">

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
                        <a href="usuarios.php">Gestión de usuarios</a>
                    </li>

                    <li>
                        <a href="reservas.php" class="activo">
                            Gestión de reservas
                        </a>
                    </li>

                    <li>
                        <a href="pagos.php">Gestión de pagos</a>
                    </li>
                </ul>
            </nav>

        </aside>

        <main class="contenido">

            <header class="encabezado">

                <div>
                    <h1>Gestión de reservas</h1>
                    <p>Administración de las reservaciones de vehículos.</p>
                </div>

                <div class="administrador">
                    <span>Administrador</span>
                </div>

            </header>

            <section class="seccion-informacion">

                <h2>Reservas del sistema</h2>

                <p>
                    Total de reservas registradas:
                    <strong><?php echo $resultado->num_rows; ?></strong>
                </p>

                <div class="tabla-contenedor">

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Correo</th>
                                <th>Vehículo</th>
                                <th>Fecha de inicio</th>
                                <th>Fecha de fin</th>
                                <th>Entrega</th>
                                <th>Devolución</th>
                                <th>Estado</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if ($resultado->num_rows > 0): ?>

                                <?php while ($reserva = $resultado->fetch_assoc()): ?>

                                    <tr>
                                        <td>
                                            <?php echo htmlspecialchars($reserva["id_reserva"]); ?>
                                        </td>

                                        <td>
                                            <?php
                                            echo htmlspecialchars(
                                                $reserva["nombre"] . " " . $reserva["apellidos"]
                                            );
                                            ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($reserva["correo"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($reserva["vehiculo"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($reserva["fecha_inicio"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($reserva["fecha_fin"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($reserva["lugar_entrega"] ?? ""); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($reserva["lugar_devolucion"] ?? ""); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($reserva["estado"]); ?>
                                        </td>

                                        <td>
                                            ₡<?php echo number_format((float) $reserva["precio_total"], 2, ",", "."); ?>
                                        </td>
                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="10">
                                        No hay reservas registradas en la base de datos.
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>
                    </table>

                </div>

            </section>

            <footer class="pie-pagina">
                <p>Ruta Tica Rent a Car | Gestión de reservas</p>
            </footer>

        </main>

    </div>

</body>
</html>
