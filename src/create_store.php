<?php
require_once 'mydatabase.php'; // Incluir conexión a la base de datos

$servername = "db";
$username = "myuser";
$password = "mypassword";
$dbname = "mydatabase";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Comprobar si los datos han sido enviados a través del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificar que todos los campos del formulario están completos
    if (empty($_POST['city']) || empty($_POST['address']) || empty($_POST['phone']) || empty($_POST['email']) || empty($_POST['opening_time']) || empty($_POST['closing_time'])) {
        die("Por favor complete todos los campos.");
    }

    // Obtener los datos del formulario
    $city = $_POST['city'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $opening_time = $_POST['opening_time'];
    $closing_time = $_POST['closing_time'];

    // Insertar los datos en la base de datos
    $insertar_datos = "INSERT INTO stores (city, address, phone, email, opening_time, closing_time) 
    VALUES ('$city', '$address', '$phone', '$email', '$opening_time', '$closing_time')";

    if (mysqli_query($conn, $insertar_datos)) {
        echo "Datos insertados correctamente";
    } else {
        echo "Error al insertar los datos: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Tienda</title>
</head>
<body>
<h1>Formulario de Datos de Tienda</h1>
<form action="create_store.php" method="POST">
    <label for="city">Ciudad:</label><br>
    <select id="city" name="city" required>
        <option value="1">Madrid</option>
        <option value="2">Barcelona</option>
        <option value="3">Marbella</option>
        <!-- Aquí deberías cargar las ciudades dinámicamente desde la base de datos -->
    </select><br><br>

    <label for="address">Dirección:</label><br>
    <input type="text" id="address" name="address" required><br><br>

    <label for="phone">Teléfono:</label><br>
    <input type="text" id="phone" name="phone" required><br><br>

    <label for="email">Correo electrónico:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="opening_time">Hora de apertura:</label><br>
    <input type="time" id="opening_time" name="opening_time" required><br><br>

    <label for="closing_time">Hora de cierre:</label><br>
    <input type="time" id="closing_time" name="closing_time" required><br><br>

    <input type="submit" value="Enviar">

    <a href="index.php" class="boton">Volver</a>

</form>
</body>
</html>
