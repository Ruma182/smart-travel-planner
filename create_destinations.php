<?php

include 'config/database.php';

$sql = "CREATE TABLE IF NOT EXISTS destinations (
    destination_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    estimated_cost DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Destinations table created successfully.<br>";
} else {
    die("Table creation failed: " . mysqli_error($conn));
}


$check = "SELECT COUNT(*) AS total FROM destinations";
$result = mysqli_query($conn, $check);
$row = mysqli_fetch_assoc($result);

if ($row["total"] == 0) {

    $sample_data = "
        INSERT INTO destinations
        (name, location, description, estimated_cost)
        VALUES

        ('Coxs Bazar', 'Chattogram, Bangladesh',
        'A famous sea beach destination with beautiful views and tourist attractions.',
        8000),

        ('Sajek Valley', 'Rangamati, Bangladesh',
        'A beautiful hill destination known for clouds, mountains and natural scenery.',
        7000),

        ('Saint Martins Island', 'Coxs Bazar, Bangladesh',
        'A popular coral island destination with beautiful beaches and clear water.',
        12000),

        ('Sylhet', 'Sylhet, Bangladesh',
        'A scenic destination famous for tea gardens, waterfalls and natural beauty.',
        6000)
    ";

    if (mysqli_query($conn, $sample_data)) {
        echo "Sample destinations added successfully.";
    }
}

?>