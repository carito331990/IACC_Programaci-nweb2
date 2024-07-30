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
    <style>
        #text-carousel {
            overflow: hidden;
            width: 70%;
            position: relative;
            height: 350px; 
            background-color: #f0f0f0; 
            padding: 20px;
            box-sizing: border-box;
            margin: 0 auto; 
        }
        .carousel-text-item {
            display: none; 
        }
        .carousel-text-item.active {
            display: block; 
        }
        .highlights {
            text-align: center; 
        }
        .arrow {
            position: absolute;
            top: 80%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background-color: rgba(133, 206, 28, 0.5);
            color: #4CAF50;
            font-size: 24px;
            text-align: center;
            line-height: 40px;
            cursor: pointer;
        }
        .arrow.prev {
            left: 10px;
        }
        .arrow.next {
            right: 10px;
        }
        .selector-buttons {
            position: absolute;
            margin-top: 310px;
            left: 56%;
            transform: translateX(-50%);
        }
        .selector-button {
            margin: 0 5px;
            padding: 5px 10px;
            background-color: rgba(208, 165, 255, 0.5);
            color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>Agencia de Viajes Carito</h1>
        <nav>
            <ul>
                <li class="active"><a href="index.php">Inicio</a></li>
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
            <div id="text-carousel">
                <div class="carousel-text-item active">
                    <h3>Descanso en la Toscana</h3>
                    <p>Destino: Toscana, Italia</p>
                    <p>Fechas: 2024-10-15 a 2024-10-22</p>
                    <p>Precio: $1800</p>
                    <p>Disfruta de la tranquilidad y el encanto de la Toscana, con visitas a viñedos y pueblos históricos.</p>
                    <button onclick="agregarAlCarrito('Descanso en la Toscana', 1800)">Agregar al Carrito</button>
                </div>
                <div class="carousel-text-item">
                    <h3>Aventura en los Alpes Suizos</h3>
                    <p>Destino: Alpes Suizos</p>
                    <p>Fechas: 2024-12-01 a 2024-12-08</p>
                    <p>Precio: $2500</p>
                    <p>Explora las majestuosas montañas de los Alpes con actividades como esquí, senderismo y mucho más.</p>
                    <button onclick="agregarAlCarrito('Aventura en los Alpes Suizos', 2500)">Agregar al Carrito</button>
                </div>
                <div class="carousel-text-item">
                    <h3>Escapada a Kyoto</h3>
                    <p>Destino: Kyoto, Japón</p>
                    <p>Fechas: 2024-11-05 a 2024-11-12</p>
                    <p>Precio: $2200</p>
                    <p>Sumérgete en la cultura japonesa con visitas a templos antiguos, jardines zen y mercados tradicionales.</p>
                    <button onclick="agregarAlCarrito('Escapada a Kyoto', 2200)">Agregar al Carrito</button>
                </div>
            </div>
            <div class="arrow prev">&#10094;</div>
            <div class="arrow next">&#10095;</div>
            <div class="selector-buttons">
                <button class="selector-button" onclick="showText(0)">1</button>
                <button class="selector-button" onclick="showText(1)">2</button>
                <button class="selector-button" onclick="showText(2)">3</button>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes Carito. Todos los derechos reservados.</p>
    </footer>
    <script src="script.js"></script>
    <script>
    var textItems = document.querySelectorAll('.carousel-text-item');
    var textIndex = 0;

    function showText(index) {
        textIndex = index;
        updateTextCarousel();
    }

    function updateTextCarousel() {
        textItems.forEach(function(item, index) {
            item.classList.remove('active');
            if (index === textIndex) {
                item.classList.add('active');
            }
        });
    }

    function prevText() {
        textIndex--;
        if (textIndex < 0) {
            textIndex = textItems.length - 1;
        }
        updateTextCarousel();
    }

    function nextText() {
        textIndex++;
        if (textIndex >= textItems.length) {
            textIndex = 0;
        }
        updateTextCarousel();
    }

    document.querySelector(".arrow.prev").addEventListener("click", prevText);
    document.querySelector(".arrow.next").addEventListener("click", nextText);
    setInterval(nextText, 10000);
    updateTextCarousel();

    function agregarAlCarrito(producto, precio) {
        const formData = new FormData();
        formData.append('agregar', true);
        formData.append('producto', producto);
        formData.append('precio', precio);

        fetch('carrito.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            alert('Producto agregado al carrito');
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    </script>
</body>
</html>
