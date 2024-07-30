<?php
session_start();

$paquetes = [
    [
        'nombre' => 'Descanso en la Toscana',
        'destino' => 'Toscana',
        'fechas' => ['2024-10-15', '2024-10-22'],
        'precio' => 1800,
        'descripcion' => 'Disfruta de la tranquilidad y el encanto de la Toscana, con visitas a viñedos y pueblos históricos.'
    ],
    [
        'nombre' => 'Aventura en los Alpes Suizos',
        'destino' => 'Alpes',
        'fechas' => ['2024-12-01', '2024-12-08'],
        'precio' => 2500,
        'descripcion' => 'Explora las majestuosas montañas de los Alpes con actividades como esquí, senderismo y mucho más.'
    ],
    [
        'nombre' => 'Escapada a Kyoto',
        'destino' => 'Kyoto',
        'fechas' => ['2024-11-05', '2024-11-12'],
        'precio' => 2200,
        'descripcion' => 'Sumérgete en la cultura japonesa con visitas a templos antiguos, jardines zen y mercados tradicionales.'
    ]
];

$resultados = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destino = $_POST['destino'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    foreach ($paquetes as $paquete) {
        if ($paquete['destino'] === $destino) {
            $resultados[] = $paquete;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilo_Agencia.css">
    <title>Resultados de Búsqueda</title>
</head>
<body>
    <header>
        <h1>Resultados de Búsqueda</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
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
        <section class="results-container">
            <h2>Paquetes Disponibles</h2>
            <ul id="packages-list">
                <?php if (empty($resultados)): ?>
                    <p>No se encontraron paquetes disponibles para los criterios de búsqueda.</p>
                <?php else: ?>
                    <?php foreach ($resultados as $paquete): ?>
                        <li>
                            <h3><?php echo $paquete['nombre']; ?></h3>
                            <p>Destino: <?php echo $paquete['destino']; ?></p>
                            <p>Fechas: <?php echo implode(', ', $paquete['fechas']); ?></p>
                            <p>Precio: $<?php echo $paquete['precio']; ?></p>
                            <p><?php echo $paquete['descripcion']; ?></p>
                            <form action="agregar_al_carrito.php" method="POST">
                                <input type="hidden" name="producto" value="<?php echo $paquete['nombre']; ?>">
                                <input type="hidden" name="precio" value="<?php echo $paquete['precio']; ?>">
                                <button type="submit">Agregar al Carrito</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes Carito. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
