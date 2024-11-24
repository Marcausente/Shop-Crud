<?php

class Database {
    private static $instance = null;
    private $conn;

    private $servername = "db";
    private $username = "myuser";
    private $password = "mypassword";
    private $dbname = "mydatabase";

    private function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}

// Uso de la clase Singleton
$db = Database::getInstance();
$conn = $db->getConnection();

// Crear tablas
function createTables($conn) {
    $queries = [
        "CREATE TABLE IF NOT EXISTS cities (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL
        )",
        "CREATE TABLE IF NOT EXISTS FoodDrinkNoExpendeable (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            name VARCHAR(100) NOT NULL,
            category ENUM('Food', 'Drink', 'NoExpendeable') NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            is_perishable BOOLEAN DEFAULT false,
            expiration_date DATE
        )",
        "CREATE TABLE IF NOT EXISTS stores (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            city INT(11) UNSIGNED NOT NULL,
            address VARCHAR(255) NOT NULL,
            phone VARCHAR(20),
            email VARCHAR(100),
            opening_time TIME,
            closing_time TIME,
            last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL,
            FOREIGN KEY (city) REFERENCES cities(id) ON DELETE CASCADE
        )",
        "CREATE TABLE IF NOT EXISTS StoresItems (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            id_store INT(11) UNSIGNED NOT NULL,
            id_item INT(11) UNSIGNED NOT NULL,
            stock_quantity INT(11) UNSIGNED NOT NULL,
            FOREIGN KEY (id_store) REFERENCES stores(id) ON DELETE CASCADE,
            FOREIGN KEY (id_item) REFERENCES FoodDrinkNoExpendeable(id) ON DELETE CASCADE
        )"
    ];

    foreach ($queries as $query) {
        if ($conn->query($query) !== true) {
            echo "Error al ejecutar query: " . $conn->error . "<br>";
        }
    }
}

// Insertar ciudades solo si no existen
function insertCities($conn) {
    $cities = [
        1 => 'Madrid',
        2 => 'Barcelona',
        3 => 'Marbella',
        4 => 'Valencia',
        6 => 'Sevilla',
        7 => 'Zaragoza',
        8 => 'Málaga',
        9 => 'Alicante',
        10 => 'Córdoba',
        11 => 'Valladolid',
        12 => 'Bilbao',
        13 => 'Palma',
        14 => 'Murcia',
        15 => 'Salamanca',
        16 => 'Granada',
        17 => 'Oviedo',
        18 => 'Logroño',
        19 => 'Girona',
        20 => 'Toledo'
    ];

    foreach ($cities as $id => $name) {
        $sqlCheck = "SELECT COUNT(*) AS count FROM cities WHERE name = '$name'";
        $result = $conn->query($sqlCheck);
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            $sqlInsert = "INSERT INTO cities (id, name) VALUES ($id, '$name')";
            if ($conn->query($sqlInsert) !== true) {
                echo "Error al insertar $name: " . $conn->error . "<br>";
            }
        }
    }
}

// Ejecutar funciones
createTables($conn);
insertCities($conn);


?>
