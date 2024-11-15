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
  //  echo "Tabla cities creada exitosamente.<br>";
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
  //  echo "Tabla Food_Drink_NoExpendeable creada exitosamente.<br>";
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
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL,
    FOREIGN KEY (city) REFERENCES cities(id) ON DELETE CASCADE
)";
if ($conn->query($sqlStores) === true) {
    //echo "Tabla stores creada exitosamente.<br>";
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

// Insertar Madrid solo si no existe
$sqlCheckMadrid = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Madrid'";
$result = $conn->query($sqlCheckMadrid);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertMadrid = "INSERT INTO cities (id, name) VALUES (1, 'Madrid')";
    if ($conn->query($sqlInsertMadrid) === true) {
        //echo "Ciudad Madrid insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Madrid: " . $conn->error . "<br>";
    }
}

// Insertar Barcelona solo si no existe
$sqlCheckBarcelona = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Barcelona'";
$result = $conn->query($sqlCheckBarcelona);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertBarcelona = "INSERT INTO cities (id, name) VALUES (2, 'Barcelona')";
    if ($conn->query($sqlInsertBarcelona) === true) {
      //  echo "Ciudad Barcelona insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Barcelona: " . $conn->error . "<br>";
    }
}

// Insertar Marbella solo si no existe
$sqlCheckMarbella = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Marbella'";
$result = $conn->query($sqlCheckMarbella);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertMarbella = "INSERT INTO cities (id, name) VALUES (3, 'Marbella')";
    if ($conn->query($sqlInsertMarbella) === true) {
        echo "Ciudad Marbella insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Marbella: " . $conn->error . "<br>";
    }
}

$sqlCheckValencia = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Valencia'";
$result = $conn->query($sqlCheckValencia);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertValencia = "INSERT INTO cities (id, name) VALUES (4, 'Valencia')";
    if ($conn->query($sqlInsertValencia) === true) {
        echo "Ciudad Valencia insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Valencia: " . $conn->error . "<br>";
    }
}
$sqlCheckSevilla = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Sevilla'";
$result = $conn->query($sqlCheckSevilla);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertSevilla = "INSERT INTO cities (id, name) VALUES (6, 'Sevilla')";
    if ($conn->query($sqlInsertSevilla) === true) {
        echo "Ciudad Sevilla insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Sevilla: " . $conn->error . "<br>";
    }
}
$sqlCheckZaragoza = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Zaragoza'";
$result = $conn->query($sqlCheckZaragoza);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertZaragoza = "INSERT INTO cities (id, name) VALUES (7, 'Zaragoza')";
    if ($conn->query($sqlInsertZaragoza) === true) {
        echo "Ciudad Zaragoza insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Zaragoza: " . $conn->error . "<br>";
    }
}

// Insertar Málaga solo si no existe
$sqlCheckMalaga = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Málaga'";
$result = $conn->query($sqlCheckMalaga);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertMalaga = "INSERT INTO cities (id, name) VALUES (8, 'Málaga')";
    if ($conn->query($sqlInsertMalaga) === true) {
        echo "Ciudad Málaga insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Málaga: " . $conn->error . "<br>";
    }
}

// Insertar Alicante solo si no existe
$sqlCheckAlicante = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Alicante'";
$result = $conn->query($sqlCheckAlicante);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertAlicante = "INSERT INTO cities (id, name) VALUES (9, 'Alicante')";
    if ($conn->query($sqlInsertAlicante) === true) {
        echo "Ciudad Alicante insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Alicante: " . $conn->error . "<br>";
    }
}

$sqlCheckCordoba = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Córdoba'";
$result = $conn->query($sqlCheckCordoba);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertCordoba = "INSERT INTO cities (id, name) VALUES (10, 'Córdoba')";
    if ($conn->query($sqlInsertCordoba) === true) {
        echo "Ciudad Córdoba insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Córdoba: " . $conn->error . "<br>";
    }
}

// Insertar Valladolid solo si no existe
$sqlCheckValladolid = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Valladolid'";
$result = $conn->query($sqlCheckValladolid);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertValladolid = "INSERT INTO cities (id, name) VALUES (11, 'Valladolid')";
    if ($conn->query($sqlInsertValladolid) === true) {
        echo "Ciudad Valladolid insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Valladolid: " . $conn->error . "<br>";
    }
}

// Insertar Bilbao solo si no existe
$sqlCheckBilbao = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Bilbao'";
$result = $conn->query($sqlCheckBilbao);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertBilbao = "INSERT INTO cities (id, name) VALUES (12, 'Bilbao')";
    if ($conn->query($sqlInsertBilbao) === true) {
        echo "Ciudad Bilbao insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Bilbao: " . $conn->error . "<br>";
    }
}

// Insertar Palma solo si no existe
$sqlCheckPalma = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Palma'";
$result = $conn->query($sqlCheckPalma);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertPalma = "INSERT INTO cities (id, name) VALUES (13, 'Palma')";
    if ($conn->query($sqlInsertPalma) === true) {
        echo "Ciudad Palma insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Palma: " . $conn->error . "<br>";
    }
}

// Insertar Murcia solo si no existe
$sqlCheckMurcia = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Murcia'";
$result = $conn->query($sqlCheckMurcia);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertMurcia = "INSERT INTO cities (id, name) VALUES (14, 'Murcia')";
    if ($conn->query($sqlInsertMurcia) === true) {
        echo "Ciudad Murcia insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Murcia: " . $conn->error . "<br>";
    }
}

// Insertar Salamanca solo si no existe
$sqlCheckSalamanca = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Salamanca'";
$result = $conn->query($sqlCheckSalamanca);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertSalamanca = "INSERT INTO cities (id, name) VALUES (15, 'Salamanca')";
    if ($conn->query($sqlInsertSalamanca) === true) {
        echo "Ciudad Salamanca insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Salamanca: " . $conn->error . "<br>";
    }
}
// Insertar Granada solo si no existe
$sqlCheckGranada = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Granada'";
$result = $conn->query($sqlCheckGranada);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertGranada = "INSERT INTO cities (id, name) VALUES (16, 'Granada')";
    if ($conn->query($sqlInsertGranada) === true) {
        echo "Ciudad Granada insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Granada: " . $conn->error . "<br>";
    }
}

// Insertar Oviedo solo si no existe
$sqlCheckOviedo = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Oviedo'";
$result = $conn->query($sqlCheckOviedo);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertOviedo = "INSERT INTO cities (id, name) VALUES (17, 'Oviedo')";
    if ($conn->query($sqlInsertOviedo) === true) {
        echo "Ciudad Oviedo insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Oviedo: " . $conn->error . "<br>";
    }
}

// Insertar Logroño solo si no existe
$sqlCheckLogrono = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Logroño'";
$result = $conn->query($sqlCheckLogrono);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertLogrono = "INSERT INTO cities (id, name) VALUES (18, 'Logroño')";
    if ($conn->query($sqlInsertLogrono) === true) {
        echo "Ciudad Logroño insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Logroño: " . $conn->error . "<br>";
    }
}

// Insertar Girona solo si no existe
$sqlCheckGirona = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Girona'";
$result = $conn->query($sqlCheckGirona);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertGirona = "INSERT INTO cities (id, name) VALUES (19, 'Girona')";
    if ($conn->query($sqlInsertGirona) === true) {
        echo "Ciudad Girona insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Girona: " . $conn->error . "<br>";
    }
}

// Insertar Toledo solo si no existe
$sqlCheckToledo = "SELECT COUNT(*) AS count FROM cities WHERE name = 'Toledo'";
$result = $conn->query($sqlCheckToledo);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sqlInsertToledo = "INSERT INTO cities (id, name) VALUES (20, 'Toledo')";
    if ($conn->query($sqlInsertToledo) === true) {
        echo "Ciudad Toledo insertada exitosamente.<br>";
    } else {
        echo "Error al insertar Toledo: " . $conn->error . "<br>";
    }
}

if ($conn->query($sqlStoresItems) === true) {
   // echo "Tabla Stores_Items creada exitosamente.<br>";
} else {
    echo "Error al crear la tabla Stores_Items: " . $conn->error . "<br>";
}

$conn->close();