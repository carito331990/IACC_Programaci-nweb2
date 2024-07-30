<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilo_Agencia.css">
    <title>Buscar Viaje</title>
</head>
<body>
    <header>
        <h1>Agencia de Viajes Carito</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li class="active"><li><a href="filtroviaje.php">Buscar Viaje</a></li>
                <li><a href="registro_viajes.php">Registro de Viajes</a></li>
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
        <section class="search-container">
            <h2>Encuentra tu viaje ideal</h2>
            <form action="resultado_busqueda.php" method="POST">
            <label for="origen">Viajo desde:</label>
            <input type="text" id="origen" name="origen" required>
            <label for="destino">Viajo hasta:</label>
            <input type="text" id="destino" name="destino" required>
                <label for="valor">Selecciona un destino:</label>
                <select name="valor" id="valor">
                    <option value="valorpasaje">Pasaje Viaje $10000</option>
                </select>
                <label for="fecha_inicio">Fecha de inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
                <label for="fecha_fin">Fecha de fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" required>
                <button type="submit">Buscar</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes Carito. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
