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
    <style>
        /* Estilo global */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #444;
        }

        /* Título */
        h1 {
            font-size: 2rem;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* Contenedor del formulario */
        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px; /* Ajustar el ancho del formulario */
        }

        /* Estilo de las etiquetas y campos de entrada */
        label {
            display: block;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"],
        input[type="time"],
        select {
            width: calc(100% - 20px); /* Ajustar el ancho para ocupar menos espacio horizontal */
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ddd;
            border-radius: 6px;
            background-color: #f9f9f9;
            font-size: 0.9rem;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="time"]:focus,
        select:focus {
            border-color: #4CAF50;
            outline: none;
        }

        /* Botón de envío */
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Estilo para el enlace */
        a.boton {
            display: block;
            text-align: center;
            color: #2196F3;
            margin-top: 15px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 10px 0;
            background-color: #e1f5fe;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        a.boton:hover {
            background-color: #bbdefb;
        }

        /* Mensajes (error, éxito, etc.) */
        .mensaje {
            color: #d32f2f;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<h1>Formulario de Datos de Tienda</h1>
<form action="create_store.php" method="POST">
    <label for="city">Ciudad:</label>
    <select id="city" name="city" required>
        <option value="1">Madrid</option>
        <option value="2">Barcelona</option>
        <option value="3">Marbella</option>
        <option value="4"></option>
        <!-- Cargar dinámicamente las ciudades desde la base de datos -->
    </select>

    <label for="address">Dirección:</label>
    <input type="text" id="address" name="address" required>

    <label for="phone">Teléfono:</label>
    <input type="text" id="phone" name="phone" required>

    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" required>

    <label for="opening_time">Hora de apertura:</label>
    <input type="time" id="opening_time" name="opening_time" required>

    <label for="closing_time">Hora de cierre:</label>
    <input type="time" id="closing_time" name="closing_time" required>

    <input type="submit" value="Enviar">

    <a href="index.php" class="boton">Volver</a>
</form>
</body>
</html>

