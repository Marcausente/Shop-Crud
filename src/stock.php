<?php
require_once 'mydatabase.php';

$conn = Database::getInstance()->getConnection();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['store_id']) && isset($_POST['stock_amount'])) {
    $storeId = intval($_POST['store_id']);
    $stockAmount = intval($_POST['stock_amount']);

    if ($stockAmount >= 0) {
        $updateStockSql = "UPDATE StoresItems SET stock_quantity = stock_quantity + ? WHERE id_store = ?";
        $stmt = $conn->prepare($updateStockSql);
        if ($stmt) {
            $stmt->bind_param("ii", $stockAmount, $storeId);
            if ($stmt->execute()) {
                $mensaje = "El stock de la tienda con ID $storeId ha sido actualizado en $stockAmount unidades.";
            } else {
                $mensaje = "Error al actualizar el stock. Inténtalo de nuevo.";
            }
            $stmt->close();
        } else {
            $mensaje = "Error al preparar la consulta.";
        }
    } else {
        $mensaje = "La cantidad de stock debe ser mayor o igual a cero.";
    }
}

$query = "
    SELECT stores.id, cities.name AS city, stores.address, stores.email, stores.phone, 
           COALESCE(SUM(StoresItems.stock_quantity), 0) AS stock_quantity
    FROM stores
    INNER JOIN cities ON stores.city = cities.id
    LEFT JOIN StoresItems ON stores.id = StoresItems.id_store
    GROUP BY stores.id";
$result = $conn->query($query);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

$stores = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tiendas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        .mensaje {
            margin: 20px 0;
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
        }
        button {
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h1>Gestión de Tiendas</h1>

<?php if ($mensaje) : ?>
    <div class="mensaje"><?php echo $mensaje; ?></div>
<?php endif; ?>

<h2>Actualizar Stock</h2>
<form action="" method="post">
    <label for="store_id">ID de la tienda:</label>
    <input type="number" name="store_id" id="store_id" required>

    <label for="stock_amount">Cantidad de stock a agregar:</label>
    <input type="number" name="stock_amount" id="stock_amount" required>

    <button type="submit">Actualizar Stock</button>
</form>

<h2>Lista de Tiendas</h2>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Ciudad</th>
        <th>Dirección</th>
        <th>Correo</th>
        <th>Teléfono</th>
        <th>Stock</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($stores as $store) : ?>
        <tr>
            <td><?php echo $store['id']; ?></td>
            <td><?php echo $store['city']; ?></td>
            <td><?php echo $store['address']; ?></td>
            <td><?php echo $store['email']; ?></td>
            <td><?php echo $store['phone']; ?></td>
            <td>
                <?php
                echo ($store['stock_quantity'] > 0) ? $store['stock_quantity'] : '&nbsp;';
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<form action="index.php" method="get">
    <button type="submit">Volver al Índice</button>
</form>
</body>
</html>
