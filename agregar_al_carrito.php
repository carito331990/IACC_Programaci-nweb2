<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];

    $item = [
        'producto' => $producto,
        'precio' => $precio
    ];

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    array_push($_SESSION['carrito'], $item);

    header('Location: carrito.php');
    exit;
}
?>
