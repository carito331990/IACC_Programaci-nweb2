<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agencia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para mostrar todas las reservas
$sql = "SELECT * FROM reserva";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID Reserva</th><th>ID Cliente</th><th>Fecha Reserva</th><th>ID Vuelo</th><th>ID Hotel</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_reserva"] . "</td>";
        echo "<td>" . $row["id_cliente"] . "</td>";
        echo "<td>" . $row["fecha_reserva"] . "</td>";
        echo "<td>" . $row["id_vuelo"] . "</td>";
        echo "<td>" . $row["id_hotel"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron reservas.";
}

$conn->close();
?>