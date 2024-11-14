<?php

$servername = "db";
$username = "myuser";
$password = "mypassword";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear tabla cities
$sqlCities = "CREATE TABLE IF NOT EXISTS cities (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
)";
if ($conn->query($sqlCities) === true) {
    echo "Tabla cities creada exitosamente.<br>";
} else {
    echo "Error al crear la tabla cities: " . $conn->error . "<br>";
}

// Crear tabla Food_Drink_NoExpendeable
$sqlFoodDrinkNoExpendeable = "CREATE TABLE IF NOT EXISTS FoodDrinkNoExpendeable(
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(100) NOT NULL,
    category ENUM('Food', 'Drink', 'NoExpendeable') NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    is_perishable BOOLEAN DEFAULT false, /* PARA VER SI CADUCA O NO */
    expiration_date DATE /* NO LO PUSE OBLIGATORIO PORQUE SOLO ES PARA FOOD Y DRINK */
)";

if ($conn->query($sqlFoodDrinkNoExpendeable) === true) {
    echo "Tabla Food_Drink_NoExpendeable creada exitosamente.<br>";
} else {
    echo "Error al crear la tabla Food_Drink_NoExpendeable: " . $conn->error . "<br>";
}

// Crear tabla stores
$sqlStores = "CREATE TABLE IF NOT EXISTS stores (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    city INT(11) UNSIGNED NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    opening_time TIME,
    closing_time TIME,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (city) REFERENCES cities(id) ON DELETE CASCADE
)";
if ($conn->query($sqlStores) === true) {
    echo "Tabla stores creada exitosamente.<br>";
} else {
    echo "Error al crear la tabla stores: " . $conn->error . "<br>";
}

// Crear tabla Stores_Items
$sqlStoresItems = "CREATE TABLE IF NOT EXISTS StoresItems (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_store INT(11) UNSIGNED NOT NULL,
    id_item INT(11) UNSIGNED NOT NULL,
    stock_quantity INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (id_store) REFERENCES stores(id) ON DELETE CASCADE,
    FOREIGN KEY (id_item) REFERENCES FoodDrinkNoExpendeable(id) ON DELETE CASCADE
)";

if ($conn->query($sqlStoresItems) === true) {
    echo "Tabla Stores_Items creada exitosamente.<br>";
} else {
    echo "Error al crear la tabla Stores_Items: " . $conn->error . "<br>";
}

$conn->close();