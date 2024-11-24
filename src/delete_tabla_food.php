<?php
require_once 'mydatabase.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $conn = Database::getInstance()->getConnection();

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $sql = "DELETE FROM FoodDrinkNoExpendeable WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
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
                <h2>¡El producto ha sido eliminado exitosamente!</h2>
                <a href="indexFoodDrinkNoexpendable.php">Volver al listado de productos</a>
            </div>
        </body>
        </html>
        ';
        exit();
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
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
        <title>Eliminar Producto</title>
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
                width: 320px;
            }
            .form-box input {
                padding: 10px 20px 10px 10px;
                font-size: 14px;
                margin-bottom: 10px;
                width: 100%;
                border-radius: 4px;
                border: 1px solid #ccc;
                box-sizing: border-box; 
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
            <h2>¿Qué producto quieres eliminar?</h2>
            <form method="POST" action="delete_tabla_food.php">
                <input type="number" name="id" placeholder="Ingresa el ID del producto" required>
                <button type="submit">Eliminar Producto</button>
            </form>
            <a href="indexFoodDrinkNoexpendable.php">Volver al listado de productos</a>
        </div>
    </body>
    </html>
    ';
}
