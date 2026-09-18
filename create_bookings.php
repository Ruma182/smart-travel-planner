<?php

include 'config/database.php';

$sql = "CREATE TABLE IF NOT EXISTS bookings (

    booking_id INT AUTO_INCREMENT PRIMARY KEY,

    traveler_id INT NOT NULL,

    provider_id INT DEFAULT NULL,

    service_type VARCHAR(50) NOT NULL,

    service_name VARCHAR(150) NOT NULL,

    booking_date DATE NOT NULL,

    number_of_people INT NOT NULL,

    total_price DECIMAL(10,2) NOT NULL,

    status VARCHAR(30) DEFAULT 'Pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)";

if (mysqli_query($conn, $sql)) {

    echo "Bookings table created successfully.";

} else {

    echo "Error: " . mysqli_error($conn);

}

?>