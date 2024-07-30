<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $origen = $_POST ['origen'];
    $destino = $_POST['destino'];
    $valor = $_POST['valor'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    

    // Precios asignados según destino
    $precios = [
        'estandar' => 10000,
    ];

    $precio = isset($precios[$valor]) ? $precios[$valor] : 0;

    // Agregar el viaje registrado al carrito
    $item = [
        'producto' => "Viaje a $destino",
        'precio' => $precio,
        'fecha_inicio' => $fecha_inicio,
        'fecha_fin' => $fecha_fin
    ];

    array_push($_SESSION['carrito'], $item);

    $_SESSION['nombre'] = $nombre;
    $_SESSION['email'] = $email;
    $_SESSION['origen'] = $origen;
    $_SESSION['destino'] = $destino;
    $_SESSION['fecha'] = $fecha;
    $_SESSION['precio'] = $precio;

    header('Location: carrito.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilo_Agencia.css">
    <title>Registro de Viajes</title>
</head>
<body>
    <header>
        <h1>Registro de Viajes</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="filtroviaje.php">Buscar Viaje</a></li>
                <li class="active"><a href="registro_viajes.php">Registro de Viajes</a></li>
                <li><a href="notificaciones.php">Notificaciones</a></li>
                <li><a href="carrito.php">Carrito de Compras</a></li>
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
        <section class="registration-form">
            <h2>Registra tu próximo viaje</h2>
            <form action="registro_viajes.php" method="POST">
                <label for="origen">Viajo desde:</label>
                <input type="text" id="origen" name="origen" required>
                <label for="destino">Viajo hasta:</label>
                <input type="text" id="destino" name="destino" required>
                <label for="valor">Selecciona el Valor:</label>
                <select name="valor" id="valor">
                    <option value="estandar">Pasaje Viaje $10000</option>
                </select>
                <label for="fecha_inicio">Fecha de inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
                <label for="fecha_fin">Fecha de fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" required>
                <button type="submit">Registrar</button>
                <button type="button" onclick="cancelar()">Cancelar</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes Carito. Todos los derechos reservados.</p>
    </footer>
    <script>
        function cancelar() {
            window.location.href = 'index.php';
        }
    </script>
</body>
</html>
