<?php
require_once 'mydatabase.php';

$conn = Database::getInstance()->getConnection();

$query = "SELECT stores.id, cities.name AS city, stores.address, stores.email, stores.phone 
          FROM stores
          INNER JOIN cities ON stores.city = cities.id;";
$result = $conn->query($query);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tiendas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            background-color: #4CAF50;
            padding: 20px;
            margin: 0;
            font-size: 2em;
        }

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

        .acciones a.actualizar {
            background-color: #ff9800;
        }

        .acciones a.actualizar:hover {
            background-color: #fb8c00; /* Naranja más oscuro */
        }
    </style>
</head>
<body>
<h1>Lista de Tiendas</h1>

<div class="acciones">
    <a href="create_store.php">Crear Nueva Tienda</a>
</div>

<div class="acciones">
    <a href="indexFoodDrinkNoexpendable.php">Ver index Food Drink</a>
</div>

<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Ciudad</th>
        <th>Dirección</th>
        <th>Email</th>
        <th>Teléfono</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $stores = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($stores as $row) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . htmlspecialchars($row['city']) . '</td>';
        echo '<td>' . htmlspecialchars($row['address']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
        echo '</tr>';
    }
    ?>
    </tbody>
</table>

<div class="acciones">
    <a href="updateTable.php" class="actualizar">Actualizar Tienda</a>
    <a href="deleteTable.php" class="eliminar">Eliminar Tienda</a>
</div>

<?php $conn->close(); ?>
</body>
</html>
