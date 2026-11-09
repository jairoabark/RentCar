
<?php
require_once "conexion.php";

// Consultar pagos relacionados con sus reservas y clientes
$sql = "SELECT
            p.id_pago,
            p.id_reserva,
            u.nombre,
            u.apellidos,
            p.monto,
            p.metodo_pago,
            p.estado,
            p.fecha_pago
        FROM pagos p
        INNER JOIN reservas r ON p.id_reserva = r.id_reserva
        INNER JOIN usuarios u ON r.id_usuario = u.id_usuario
        ORDER BY p.id_pago DESC";

$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error al consultar pagos: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestión de pagos | Ruta Tica Rent a Car</title>

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
                        <a href="usuarios.php">Gestión de usuarios</a>
                    </li>

                    <li>
                        <a href="reservas.php">Gestión de reservas</a>
                    </li>

                    <li>
                        <a href="pagos.php" class="activo">
                            Gestión de pagos
                        </a>
                    </li>
                </ul>
            </nav>

        </aside>

        <!-- Contenido principal -->
        <main class="contenido">

            <header class="encabezado">

                <div>
                    <h1>Gestión de pagos</h1>
                    <p>Administración de los pagos asociados a las reservas.</p>
                </div>

                <div class="administrador">
                    <span>Administrador</span>
                </div>

            </header>

            <!-- Tabla de pagos -->
            <section class="seccion-informacion">

                <h2>Pagos del sistema</h2>

                <p>
                    Total de pagos registrados:
                    <strong><?php echo $resultado->num_rows; ?></strong>
                </p>

                <div class="tabla-contenedor">

                    <table>
                        <thead>
                            <tr>
                                <th>ID Pago</th>
                                <th>ID Reserva</th>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Método de pago</th>
                                <th>Estado</th>
                                <th>Fecha de pago</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if ($resultado->num_rows > 0): ?>

                                <?php while ($pago = $resultado->fetch_assoc()): ?>

                                    <tr>
                                        <td>
                                            <?php echo htmlspecialchars($pago["id_pago"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($pago["id_reserva"]); ?>
                                        </td>

                                        <td>
                                            <?php
                                            echo htmlspecialchars(
                                                $pago["nombre"] . " " . $pago["apellidos"]
                                            );
                                            ?>
                                        </td>

                                        <td>
                                            ₡<?php echo number_format((float) $pago["monto"], 2, ",", "."); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($pago["metodo_pago"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($pago["estado"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($pago["fecha_pago"]); ?>
                                        </td>
                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="7">
                                        No hay pagos registrados en la base de datos.
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>
                    </table>

                </div>

            </section>

            <footer class="pie-pagina">
                <p>Ruta Tica Rent a Car | Gestión de pagos</p>
            </footer>

        </main>

    </div>

</body>
</html>
