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
                <a href="delete_store.php?id=<?php echo $row['id']; ?>">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<?php $conn->close(); ?>
</body>
</html>