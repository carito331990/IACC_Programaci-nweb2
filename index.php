<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilo_Agencia.css">
    <title>Agencia de Viajes Carito</title>
</head>
<body>
    <header>
        <h1>Agencia de Viajes Carito</h1>
        <nav>
            <ul>
                <li class="active"><li><a href="index.php">Inicio</a></li>
                <li><a href="filtroviaje.php">Buscar Viaje</a></li>
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
        <section class="intro">
            <h2>Bienvenido a tu próximo destino</h2>
            <p>En Agencia de Viajes Carito, ofrecemos experiencias únicas e inolvidables. Descubre nuestros paquetes turísticos y comienza tu aventura.</p>
        </section>
        <section class="highlights">
            <h2>Paquetes Destacados</h2>
            <div class="package">
                <h3>Descanso en la Toscana</h3>
                <p>Destino: Toscana, Italia</p>
                <p>Fechas: 2024-10-15 a 2024-10-22</p>
                <p>Precio: $1800</p>
                <p>Disfruta de la tranquilidad y el encanto de la Toscana, con visitas a viñedos y pueblos históricos.</p>
                <button onclick="agregarAlCarrito('Descanso en la Toscana', 1800)">Agregar al Carrito</button>
            </div>
            <div class="package">
                <h3>Aventura en los Alpes Suizos</h3>
                <p>Destino: Alpes Suizos</p>
                <p>Fechas: 2024-12-01 a 2024-12-08</p>
                <p>Precio: $2500</p>
                <p>Explora las majestuosas montañas de los Alpes con actividades como esquí, senderismo y mucho más.</p>
                <button onclick="agregarAlCarrito('Aventura en los Alpes Suizos', 2500)">Agregar al Carrito</button>
            </div>
            <div class="package">
                <h3>Escapada a Kyoto</h3>
                <p>Destino: Kyoto, Japón</p>
                <p>Fechas: 2024-11-05 a 2024-11-12</p>
                <p>Precio: $2200</p>
                <p>Sumérgete en la cultura japonesa con visitas a templos antiguos, jardines zen y mercados tradicionales.</p>
                <button onclick="agregarAlCarrito('Escapada a Kyoto', 2200)">Agregar al Carrito</button>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes Carito. Todos los derechos reservados.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
