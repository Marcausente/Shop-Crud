<?php
require_once 'mydatabase.php'; // Incluir conexión a la base de datos

$servername = "db";
$username = "myuser";
$password = "mypassword";
$dbname = "mydatabase";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los productos de la tabla FoodDrinkNoExpendeable
$query = "SELECT id, name, category, price, is_perishable, expiration_date FROM FoodDrinkNoExpendeable;";
$result = $conn->query($query);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alimentos y Bebidas No Expendeables</title>
    <style>
        /* Estilo global para la página */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Estilo para el encabezado */
        h1 {
            text-align: center;
            color: #333;
            background-color: #4CAF50;
            padding: 20px;
            margin: 0;
            font-size: 2em;
        }

        /* Estilo para el enlace de crear nuevo producto */
        a {
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin: 10px;
        }

        a:hover {
            background-color: #45a049;
        }

        /* Estilo para la tabla */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* Estilo para los botones fuera de la tabla */
        .acciones {
            text-align: center;
            margin: 20px;
        }

        .acciones a {
            background-color: #2196F3;
        }

        .acciones a.eliminar {
            background-color: #f44336;
        }
    </style>
</head>
<body>
<h1>Lista de Alimentos y Bebidas No Expendeables</h1>

<!-- Botón de acción para agregar un nuevo producto -->
<div class="acciones">
    <a href="create_store_food.php">Crear Nuevo Producto</a>
</div>

<div class="acciones">
    <a href="index.php">Volver al Índice</a>
</div>

<!-- Tabla de productos -->
<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Precio</th>
        <th>Perecedero</th>
        <th>Fecha de Expiración</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Obtener todos los productos
    $products = $result->fetch_all(MYSQLI_ASSOC);  // Obtenemos todos los registros en un array

    // Mostrar los productos en la tabla
    foreach ($products as $row) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['category']) . '</td>';
        echo '<td>' . htmlspecialchars($row['price']) . '</td>';
        echo '<td>' . ($row['is_perishable'] ? 'Sí' : 'No') . '</td>';
        echo '<td>' . htmlspecialchars($row['expiration_date']) . '</td>';
        echo '</tr>';
    }
    ?>
    </tbody>
</table>

<!-- Botones de acción fuera de la tabla -->
<div class="acciones">
    <a href="update_food_drink.php">Actualizar Producto</a>
    <a href="delete_food_drink.php" class="eliminar">Eliminar Producto</a>
</div>

<?php $conn->close(); ?>
</body>
</html>
