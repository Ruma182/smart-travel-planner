<?php

include 'config/database.php';

$sql = "CREATE TABLE IF NOT EXISTS services (

    service_id INT AUTO_INCREMENT PRIMARY KEY,

    provider_id INT NOT NULL,

    service_type VARCHAR(50) NOT NULL,

    service_name VARCHAR(150) NOT NULL,

    location VARCHAR(150) NOT NULL,

    description TEXT NOT NULL,

    price DECIMAL(10,2) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)";

if (mysqli_query($conn, $sql)) {

    echo "Services table created successfully.";

} else {

    echo "Error: " . mysqli_error($conn);

}

?>