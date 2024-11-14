<?php
require_once 'mydatabase.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $servername = "db";
    $username = "myuser";
    $password = "mypassword";
    $dbname = "mydatabase";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "DELETE FROM stores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {

    } else {
        echo "Error al eliminar la tienda: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "No se ha especificado una tienda para eliminar.";
}

$conn->close();
?>

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
    <h2>¡Tu tienda ha sido eliminada exitosamente!</h2>
    <a href="index.php">Volver</a>
</div>
</body>
</html>
