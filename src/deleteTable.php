<?php
require_once 'mydatabase.php'; // Incluir la conexión a la base de datos

// Si el formulario ha sido enviado
if (isset($_POST['id'])) {
    $id = $_POST['id']; // Obtener el ID enviado por el formulario

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

    // Preparar la consulta para eliminar la tienda con el ID especificado
    $sql = "DELETE FROM stores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta de eliminación
    if ($stmt->execute()) {
        // Mostrar mensaje de éxito si la tienda se eliminó
        echo '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Confirmación de Eliminación</title>
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
                <h2>¡La tienda ha sido eliminada exitosamente!</h2>
                <a href="index.php">Volver al listado de tiendas</a>
            </div>
        </body>
        </html>
        ';
        exit(); // Detener la ejecución del script
    } else {
        echo "Error al eliminar la tienda: " . $conn->error;
    }

    $stmt->close(); // Cerrar la declaración
    $conn->close(); // Cerrar la conexión
} else {
    // Mostrar formulario si no se ha enviado el ID
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Eliminar Tienda</title>
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
                background-color: #f8d7da;
                border: 1px solid #f5c6cb;
                color: #721c24;
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
                background-color: #d9534f;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }
            .form-box button:hover {
                background-color: #c9302c;
            }
        </style>
    </head>
    <body>
        <div class="form-box">
            <h2>¿Qué tienda quieres eliminar?</h2>
            <form method="POST" action="deleteTable.php">
                <input type="number" name="id" placeholder="Ingresa el ID de la tienda" required>
                <button type="submit">Eliminar Tienda</button>
            </form>
            <a href="index.php">Volver al listado de tiendas</a>
        </div>
    </body>
    </html>
    ';
}
?>
