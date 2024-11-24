<?php
require_once 'mydatabase.php';

$conn = Database::getInstance()->getConnection(); // Crear conexión a la base de datos

// Mensaje para mostrar el éxito o error de la actualización
$mensaje = '';

// Verificar si se ha enviado el formulario para actualizar el stock
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['store_id']) && isset($_POST['stock_amount'])) {
    $storeId = intval($_POST['store_id']);
    $stockAmount = intval($_POST['stock_amount']);

    // Validar que la cantidad de stock sea mayor que cero
    if ($stockAmount > 0) {
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
        $mensaje = "La cantidad de stock debe ser mayor que cero.";
    }
}

// Obtener todas las tiendas y su stock actual
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

$stores = $result->fetch_all(MYSQLI_ASSOC); // Obtener todas las tiendas y su stock

$conn->close(); // Ahora cerramos la conexión después de usarla
?>
