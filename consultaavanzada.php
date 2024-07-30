
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

// Consulta avanzada para mostrar hoteles con más de dos reservas
$sql = "
    SELECT h.nombre, COUNT(r.id_reserva) AS total_reservas
    FROM hotel h
    JOIN reserva r ON h.id_hotel = r.id_hotel
    GROUP BY h.nombre
    HAVING COUNT(r.id_reserva) > 2
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Nombre del Hotel</th><th>Total de Reservas</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["nombre"] . "</td>";
        echo "<td>" . $row["total_reservas"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron hoteles con más de dos reservas.";
}

$conn->close();
?>