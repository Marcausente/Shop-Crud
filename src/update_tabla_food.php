<?php

require_once 'mydatabase.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $is_perishable = isset($_POST['is_perishable']) ? 1 : 0;
    $caducidad = $_POST['caducidad'];

    $conn = Database::getInstance()->getConnection();

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $sql = "UPDATE FoodDrinkNoExpendeable SET category = ?,
    price = ?, is_perishable = ?, expiration_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $type, $price, $is_perishable, $caducidad, $id);

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
                <a href="indexFoodDrinkNoexpendable.php">Volver al listado de productos</a>
            </div>
        </body>
        </html>
        ';
    } else {
        echo "Error al actualizar el producto: " . $conn->error;
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
            <form method="POST" action="update_tabla_food.php">
                <input type="number" name="id" placeholder="ID del producto" required>
                <label for="type">Tipo:</label>
                <select id="type" name="type" required>
                    <option value="Food">Food</option>
                    <option value="Drink">Drink</option>
                    <option value="NoExpendeable">No Expendeable</option>
                </select>
                <input type="number" name="price" placeholder="Nuevo precio" required>
                <label for="is_perishable">¿Es perecedero?</label>
                <input type="checkbox" id="is_perishable" name="is_perishable">
                <label for="caducidad">Nueva caducidad:</label>
                <input type="date" name="caducidad" required>
                <button type="submit">Actualizar Producto</button>
            </form>
            <a href="indexFoodDrinkNoexpendable.php">Volver al listado de productos</a>
        </div>
    </body>
    </html>
    ';
}
