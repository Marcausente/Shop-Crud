<?php
require_once 'mydatabase.php'; // Incluir la conexión a la base de datos

// Si se ha enviado el formulario con el ID
if (isset($_POST['id'])) {
    $id = $_POST['id']; // Obtener el ID de la tienda

    // Obtener los nuevos valores de los campos
    $city = $_POST['city']; // Obtener la ciudad
    $email = $_POST['email']; // Obtener el email
    $phone = $_POST['phone']; // Obtener el teléfono
    $address = $_POST['address']; // Obtener la dirección

    // Conexión a la base de datos
    $servername = "db";
    $username = "myuser";
    $password = "mypassword";
    $dbname = "mydatabase";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar la consulta de actualización
    $sql = "UPDATE stores SET city = ?, email = ?, phone = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $city, $email, $phone, $address, $id);

    if ($stmt->execute()) {
        echo "Tienda actualizada exitosamente. <a href='index.php'>Volver al listado</a>";
    } else {
        echo "Error al actualizar la tienda: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Mostrar formulario si no se ha enviado el ID
    echo '
    <form method="POST" action="updateTable.php">
        <label for="id">ID de la tienda:</label>
        <input type="number" name="id" placeholder="ID de la tienda" required><br><br>
        
        <label for="city">Ciudad:</label>
        <input type="text" name="city" placeholder="Nueva ciudad" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Nuevo email" required><br><br>
        
        <label for="phone">Teléfono:</label>
        <input type="text" name="phone" placeholder="Nuevo teléfono" required><br><br>
        
        <label for="address">Dirección:</label>
        <input type="text" name="address" placeholder="Nueva dirección" required><br><br>
        
        <button type="submit">Actualizar Tienda</button>
    </form>
    <br>
    <a href="index.php">Volver al listado de tiendas</a>
    ';
}
?>
