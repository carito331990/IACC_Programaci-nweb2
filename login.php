<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agencia";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT id_cliente, contraseña FROM clientes WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($contrasena, $row['contraseña'])) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['id_cliente'] = $row['id_cliente'];
            header('Location: index.php');
            exit();
        } else {
            $error_message = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error_message = "Usuario o contraseña incorrectos.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilo_Agencia.css">
    <title>Iniciar sesión - Agencia de Viajes Carito</title>
    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }
        .login-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
        }
        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .login-form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
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
    <main class="login-container">
        <div class="login-form">
            <h2>Iniciar sesión</h2>
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="usuario">Usuario:</label><br>
                <input type="text" id="usuario" name="usuario" required><br><br>
                <label for="contrasena">Contraseña:</label><br>
                <input type="password" id="contrasena" name="contrasena" required><br><br>
                <input type="submit" value="Iniciar sesión">
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Agencia de Viajes Carito. Todos los derechos reservados.</p>
    </footer>
</body>
</html>