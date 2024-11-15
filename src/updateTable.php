<?php
require_once 'mydatabase.php'; // Incluir la conexión a la base de datos

// Si se ha enviado el formulario con el ID
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $city = $_POST['city'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $servername = "db";
    $username = "myuser";
    $password = "mypassword";
    $dbname = "mydatabase";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "UPDATE stores SET city = ?, email = ?, phone = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $city, $email, $phone, $address, $id);

    if ($stmt->execute()) {
        echo '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Actualización de Tienda</title>
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
    } else {
        echo "Error al actualizar la tienda: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
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
                background-color: #fff3cd;
                border: 1px solid #ffeeba;
                color: #856404;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 320px;
            }
            .form-box input {
                padding: 10px 20px 10px 10px; /* Agregar más padding a la derecha */
                font-size: 14px;
                margin-bottom: 10px;
                width: 100%;
                border-radius: 4px;
                border: 1px solid #ccc;
                box-sizing: border-box; /* Asegura que el padding no afecte el ancho total */
            }
            .form-box button {
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }
            .form-box button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="form-box">
            <h2>Actualizar información de la tienda</h2>
            <form method="POST" action="updateTable.php">
                <input type="number" name="id" placeholder="ID de la tienda" required><br>
                <input type="text" name="city" placeholder="Nueva ciudad" required><br>
                <input type="email" name="email" placeholder="Nuevo email" required><br>
                <input type="text" name="phone" placeholder="Nuevo teléfono" required><br>
                <input type="text" name="address" placeholder="Nueva dirección" required><br>
                <button type="submit">Actualizar Tienda</button>
            </form>
            <br>
            <a href="index.php">Volver al listado de tiendas</a>
        </div>
    </body>
    </html>
    ';
}
?>
