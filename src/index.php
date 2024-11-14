<?php
require_once 'mydatabase.php'; // Incluir conexión a la base de datos
$servername = "db";
$username = "myuser";
$password = "mypassword";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
// Obtener las tiendas de la base de datos
$query = "SELECT stores.id, cities.name AS city, stores.email, stores.phone 
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

        /* Estilo para el enlace de crear nueva tienda */
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

        /* Estilo para las acciones de la tabla */
        td a {
            text-decoration: none;
            color: #2196F3;
            margin-right: 10px;
        }

        td a:hover {
            color: #0b7dda;
        }
    </style>
</head>
<body>
<h1>Lista de Tiendas</h1>

<!-- Botón para crear una nueva tienda -->
<a href="create_store.php">Crear Nueva Tienda</a>

<!-- Tabla de tiendas -->
<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Ciudad</th>
        <th>Email</th>
        <th>Teléfono</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['city']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td>
                <a href="update_store.php?id=<?php echo $row['id']; ?>">Actualizar</a>
                <a href="deleteTable.php?id=<?php echo $row['id']; ?>">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<?php $conn->close(); ?>
</body>
</html>