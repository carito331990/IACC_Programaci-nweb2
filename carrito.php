<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar producto al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];

    $item = [
        'producto' => $producto,
        'precio' => $precio
    ];

    array_push($_SESSION['carrito'], $item);
}

// Eliminar producto del carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $index = $_POST['index'];
    unset($_SESSION['carrito'][$index]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el array
}

// Proceder al pago e insertar datos en la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['proceder_pago'])) {
    if (!isset($_SESSION['id_cliente'])) {
        echo "Error: id_cliente no está definido en la sesión.";
        exit();
    }
    $id_cliente = $_SESSION['id_cliente'];
    $fecha_reserva = date('Y-m-d');

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agencia";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    foreach ($_SESSION['carrito'] as $item) {
        $origen = $_SESSION['origen'];
        $destino = $_SESSION['destino'];
        $fecha_inicio = $_SESSION['fecha_inicio'];
        $fecha_fin = $_SESSION['fecha_fin'];
        $precio = $item['precio'];

        // Insertar vuelo
        $sqlVuelo = "INSERT INTO vuelo (origen, destino, fecha, plazas_disponibles, precio) VALUES (?, ?, ?, ?, ?)";
        $stmtVuelo = $conn->prepare($sqlVuelo);
        $plazas_disponibles = 1;
        $stmtVuelo->bind_param("sssii", $origen, $destino, $fecha_inicio, $plazas_disponibles, $precio);

        if ($stmtVuelo->execute()) {
            $id_vuelo = $stmtVuelo->insert_id;
        } else {
            echo "Error: " . $stmtVuelo->error;
            exit();
        }
        $stmtVuelo->close();

        // Obtener id_hotel (aquí necesitas asegurarte de que el nombre del hotel y la ubicación estén definidos correctamente)
        $nombreHotel = 'Hotel del Mar'; // Ejemplo, cambiar según tu lógica
        $ciudad = 'Cancún'; // Ejemplo, cambiar según tu lógica
        $sqlHotel = "SELECT id_hotel FROM hotel WHERE nombre = ? AND ubicación = ?";
        $stmtHotel = $conn->prepare($sqlHotel);
        $stmtHotel->bind_param("ss", $nombreHotel, $ciudad);
        $stmtHotel->execute();
        $stmtHotel->bind_result($id_hotel);
        $stmtHotel->fetch();
        $stmtHotel->close();

        if (!$id_hotel) {
            echo "Error: No se encontró el hotel especificado.";
            exit();
        }

        // Insertar reserva
        $sqlReserva = "INSERT INTO reserva (id_cliente, fecha_reserva, id_vuelo, id_hotel) VALUES (?, ?, ?, ?)";
        $stmtReserva = $conn->prepare($sqlReserva);
        $stmtReserva->bind_param("isii", $id_cliente, $fecha_reserva, $id_vuelo, $id_hotel);

        if ($stmtReserva->execute()) {
            echo "<script>alert('Reserva confirmada con éxito.');</script>";
        } else {
            echo "Error: " . $stmtReserva->error;
            exit();
        }

        $stmtReserva->close();
    }

    $conn->close();
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilo_Agencia.css">
    <title>Carrito de Compras</title>
</head>
<body>
    <header>
        <h1>Carrito de Compras</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="filtroviaje.php">Buscar Viaje</a></li>
                <li><a href="registro_viajes.php">Registro de Viajes</a></li>
                <li><a href="notificaciones.php">Notificaciones</a></li>
                <li class="active"><a href="carrito.php">Carrito de Compras</a></li>
                <?php
                if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) {
                    echo '<li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>';
                } else {
                    echo '<li><a href="login.php">Iniciar Sesión</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
    <main>
        <section class="cart">
            <h2>Resumen del Carrito</h2>
            <?php if (empty($_SESSION['carrito'])): ?>
                <p>Tu carrito está vacío.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['carrito'] as $index => $item): ?>
                            <tr>
                                <td><?php echo $item['producto']; ?></td>
                                <td>$<?php echo $item['precio']; ?></td>
                                <td>
                                    <form method="POST" action="carrito.php">
                                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                                        <button type="submit" name="eliminar">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <form method="POST" action="carrito.php">
                    <button type="submit" name="proceder_pago" onclick="alert('Se enviará la confirmación a tu correo electrónico ¡Gracias por preferirnos!');">Proceder al Pago</button>
                </form>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes Carito. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
