<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rut = $_POST['rut'];
    $limpiar_rut = preg_replace('/[^0-9kK]/', '', $rut); // Eliminar caracteres no numéricos, mantener solo números y 'k/K'
    
    // Convertir 'k' o 'K' a '11' (dígito verificador)
    if (substr($limpiar_rut, -1) == 'K') {
        $idclien = substr($limpiar_rut, 0, -1) . '99';
    } else {
        $idclien = $limpiar_rut;
    }
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Encriptar la contraseña

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agencia";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Falla de conexión: " . $conn->connect_error);
    }

    $sql = "INSERT INTO clientes (id_cliente, nombre, email, usuario, contraseña) 
        VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $idclien, $nombre, $email, $usuario, $contrasena);

    if ($stmt->execute() === TRUE) {
        echo "Cuenta creada.";
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agencia de Viajes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <form method="POST" action="crear_cuenta.php">
    <h2>Crear Cuenta</h2>
        <label for="rut">RUT:</label>
        <input type="text" id="rut" name="rut" required>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <button type="submit">Crear Cuenta</button>
        <button onclick="location.href='index.php'">Volver al inicio de sesión</button>
    </form>
</body>
</html>