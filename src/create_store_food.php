<?php
require_once 'mydatabase.php'; // Incluye la conexión a la base de datos
require_once 'FoodDrinkNoExpendeable.php';

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

    // Verificar que todos los campos obligatorios están completos
    if (empty($_POST['name']) || empty($_POST['category']) || empty($_POST['price'])) {
        die("Por favor complete todos los campos obligatorios.");
    }

    $is_perishable = isset($_POST['is_perishable']) ? 1 : 0;
    $expiration_date = !empty($_POST['expiration_date']) ? $_POST['expiration_date'] : NULL;

    $item = new FoodDrinkNoExpendeable(
        $_POST['name'],
        $_POST['category'],
        $_POST['price'],
        $is_perishable,
        $expiration_date
    );

    // Insertar los datos en la base de datos
    if($item->saveToDatabase($conn)){
        echo "Se ha creado un nuevo producto.";
    }else{
        echo "No se ha podido crear el producto.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Productos</title>
    <style>
        /* Estilos para el formulario */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        label, input, select {
            display: block;
            width: 100%;
            margin-bottom: 15px;
        }
        input[type="text"], input[type="number"], input[type="date"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            margin-bottom: 10px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* Botón de regreso */
        input[type="button"] {
            padding: 10px;
            background-color: #2196F3;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        input[type="button"]:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>

<h2>Formulario de Registro de Productos</h2>
<form action="create_store_food.php" method="POST">
    <label for="name">Nombre del Producto:</label>
    <input type="text" id="name" name="name" required>

    <label for="category">Categoría:</label>
    <select id="category" name="category" required>
        <option value="Food">Food</option>
        <option value="Drink">Drink</option>
        <option value="NoExpendeable">No Expendeable</option>
    </select>

    <label for="price">Precio:</label>
    <input type="number" id="price" name="price" step="0.01" required>

    <label for="is_perishable">¿Es perecedero?</label>
    <input type="checkbox" id="is_perishable" name="is_perishable">

    <label for="expiration_date">Fecha de Caducidad:</label>
    <input type="date" id="expiration_date" name="expiration_date">

    <input type="submit" value="Enviar">

    <a href="indexFoodDrinkNoexpendable.php" class="boton">Volver</a>
</form>
</body>
</html>
