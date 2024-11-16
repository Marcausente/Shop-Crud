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
            <title>Actualización de Productos</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                    margin: 0;
                    background-color: #f9f9f9;
                }
                .message-box {
                    background-color: #e9ffe9;
                    border: 1px solid #8ee88e;
                    color: #2e7d32;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    max-width: 400px;
                    width: 90%;
                }
                .message-box a {
                    display: inline-block;
                    margin-top: 15px;
                    padding: 10px 20px;
                    background-color: #2e7d32;
                    color: white;
                    text-decoration: none;
                    font-weight: bold;
                    border-radius: 5px;
                    transition: background-color 0.3s;
                }
                .message-box a:hover {
                    background-color: #25662b;
                }
            </style>
        </head>
        <body>
            <div class="message-box">
                <h2>¡El producto ha sido actualizado correctamente!</h2>
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
        <title>Actualizar Productos</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
                background-color: #f9f9f9;
            }
            .form-box {
                background-color: #fff8e1;
                border: 1px solid #ffd54f;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                text-align: center;
                max-width: 400px;
                width: 90%;
            }
            .form-box h2 {
                color: #ff8f00;
                margin-bottom: 20px;
            }
            .form-box input,
            .form-box select {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 14px;
                box-sizing: border-box;
            }
            .form-box button {
                width: 100%;
                padding: 10px;
                background-color: #ff8f00;
                color: white;
                border: none;
                border-radius: 5px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .form-box button:hover {
                background-color: #ff6f00;
            }
            .form-box a {
                display: inline-block;
                margin-top: 10px;
                text-decoration: none;
                color: #ff8f00;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="form-box">
            <h2>Actualizar información del producto</h2>
            <form method="POST" action="updateTable.php">
                <input type="number" name="id" placeholder="ID de la tienda" required>
                <label for="city">Ciudad:</label>
                <select id="city" name="city" required>
                    <option value="1">Madrid</option>
                    <option value="2">Barcelona</option>
                    <option value="3">Marbella</option>
                    <option value="4">Valencia</option>
                    <option value="6">Sevilla</option>
                    <option value="7">Zaragoza</option>
                    <option value="8">Málaga</option>
                    <option value="9">Alicante</option>
                    <option value="10">Córdoba</option>
                    <option value="11">Valladolid</option>
                    <option value="12">Bilbao</option>
                    <option value="13">Palma</option>
                    <option value="14">Murcia</option>
                    <option value="15">Salamanca</option>
                    <option value="16">Granada</option>
                    <option value="17">Oviedo</option>
                    <option value="18">Logroño</option>
                    <option value="19">Girona</option>
                    <option value="20">Toledo</option>
                </select>
                <input type="email" name="email" placeholder="Nuevo email" required>
                <input type="text" name="phone" placeholder="Nuevo teléfono" required>
                <input type="text" name="address" placeholder="Nueva dirección" required>
                <button type="submit">Actualizar Tienda</button>
            </form>
            <a href="indexFoodDrinkNoexpendable.php">Volver al listado de productos</a>
        </div>
    </body>
    </html>
    ';
}
?>