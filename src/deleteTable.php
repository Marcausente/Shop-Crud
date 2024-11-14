<?php
require_once 'mydatabase.php';

if (isset($_POST['id'])) {
$id = $_POST['id'];

$servername = "db";
$username = "myuser";
$password = "mypassword";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
die("Conexión fallida: " . $conn->connect_error);
}

$sql = "DELETE FROM cities WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
echo "Comanda eliminada exitosamente.<br>";
} else {
echo "Error al eliminar la comanda: " . $conn->error . "<br>";
}

$stmt->close();
$conn->close();

}