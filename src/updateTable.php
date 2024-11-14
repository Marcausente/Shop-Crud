<?php
require_once 'mydatabase.php'; // Incluir la conexión a la base de datos

// Si el formulario ha sido enviado
if (isset($_POST['id'])) {
    $id = $_POST['id']; // Obtener el ID de la tienda
    $city = $_POST['city']; // Obtener la ciudad
    $email = $_POST['email']; // Obtener el email
    $phone = $_POST['phone']; // Obtener el teléfono

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

    // Preparar la consulta para actualizar la tienda con el ID especificado
    $sql = "UPDATE stores SET city = ?, email = ?, phone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $city, $email, $phone, $id);

    // Ejecutar la consulta de actualización
    if ($stmt->execute()) {
        // Mostrar mensaje de éxito si la tienda se actualizó
        echo '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Confirmación de Actualización</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background-color: #f4f4f9;
                }
                .message-box {
                    background-color: #d4edda;
                    border: 1px solid #c3e6cb;
                    color: #155724;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    width: 300px;
                }
                .message-box a {
                    text-decoration: none;
                    color: #155724;
                    font-weight: bold;
                    margin-top: 10px;
                    display: inline-block;
                }
            </style>
        </head>
        <body>
            <div class="message-box">
                <h2>¡La tienda ha sido actualizada exitosamente!</h2>
                <a href="index.php">Volver al listado de tiendas</a>
            </div>
        </body>
        </html>
        ';
        exit(); // Detener la ejecución del script
    } else {
        echo "Error al actualizar la tienda: " . $conn->error;
    }

    $stmt->close(); // Cerrar la declaración
    $conn->close(); // Cerrar la conexión
} else {
    // Verificar si se ha enviado el ID para cargar los datos de la tienda
    if (isset($_GET['id'])) {
        $id = $_GET['id']; // Obtener el ID de la tienda

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

        // Consultar los datos de la tienda
        $sql = "SELECT id, city, email, phone FROM stores WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $city = $row['city'];
            $email = $row['email'];
            $phone = $row['phone'];
        } else {
            echo "No se encontró la tienda con el ID especificado.";
            exit();
        }

        $stmt->close(); // Cerrar la declaración
        $conn->close(); // Cerrar la conexión

        // Mostrar formulario de actualización con los datos actuales
        echo '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Actualizar Tienda</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background-color: #f4f4f9;
                }
                .form-box {
                    background-color: #d1ecf1;
                    border: 1px solid #bee5eb;
                    color: #0c5460;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    width: 300px;
                }
                .form-box input {
                    padding: 10px;
                    font-size: 14px;
                    margin-bottom: 10px;
                    width: 100%;
                    border-radius: 4px;
                    border: 1px solid #ccc;
                }
                .form-box button {
                    padding: 10px 20px;
                    background-color: #28a745;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 16px;
                }
                .form-box button:hover {
                    background-color: #218838;
                }
            </style>
        </head>
        <body>
            <div class="form-box">
                <h2>Actualizar Tienda</h2>
                <form method="POST" action="update_store.php">
                    <input type="hidden" name="id" value="' . $id . '">
                    <input type="text" name="city" value="' . htmlspecialchars($city) . '" placeholder="Ciudad" required>
                    <input type="email" name="email" value="' . htmlspecialchars($email) . '" placeholder="Email" required>
                    <input type="tel" name="phone" value="' . htmlspecialchars($phone) . '" placeholder="Teléfono" required>
                    <button type="submit">Actualizar Tienda</button>
                </form>
                <a href="index.php">Volver al listado de tiendas</a>
            </div>
        </body>
        </html>
        ';
    } else {
        echo "No se ha especificado una tienda para actualizar.";
    }
}
?>

