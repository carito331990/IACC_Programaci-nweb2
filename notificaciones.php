<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilo_Agencia.css">
    <title>Notificaciones</title>
</head>
<body>
    <header>
        <h1>Notificaciones</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="filtroviaje.php">Buscar Viaje</a></li>
                <li><a href="registro_viajes.php">Registro de Viajes</a></li>
                <li class="active"><li><a href="notificaciones.php">Notificaciones</a></li>
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
    <section class="notifications-container">
            <h2>Últimas Notificaciones</h2>
            <ul id="notifications-list">
                <?php
                    include 'data.php';
                    foreach ($notificaciones as $notificacion) {
                        echo "<li class='notification-item' onclick='showPopup(\"" . addslashes($notificacion) . "\")'>" . $notificacion . "</li>";
                    }
                ?>
            </ul>
        </section>
        <div id="popup" class="popup">
            <div class="popup-content">
                <span class="close" onclick="hidePopup()">&times;</span>
                <p id="popup-message"></p>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes Carito. Todos los derechos reservados.</p>
    </footer>
    <script>
        function showPopup(message) {
            document.getElementById('popup-message').innerText = message;
            document.getElementById('popup').style.display = 'block';
        }

        function hidePopup() {
            document.getElementById('popup').style.display = 'none';
        }
    </script>
</body>
</html>
