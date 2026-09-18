<?php

header("Content-Type: application/json");

$destination = isset($_GET["destination"])
    ? strtolower(trim($_GET["destination"]))
    : "";


$weatherData = [

    "dhaka" => [
        "condition" => "Sunny",
        "temperature" => 30,
        "humidity" => 70
    ],

    "cox's bazar" => [
        "condition" => "Cloudy",
        "temperature" => 29,
        "humidity" => 75
    ],

    "sylhet" => [
        "condition" => "Rainy",
        "temperature" => 26,
        "humidity" => 85
    ],

    "chattogram" => [
        "condition" => "Partly Cloudy",
        "temperature" => 28,
        "humidity" => 78
    ]

];


if (isset($weatherData[$destination])) {

    echo json_encode([

        "success" => true,

        "destination" =>
            ucwords($destination),

        "condition" =>
            $weatherData[$destination]["condition"],

        "temperature" =>
            $weatherData[$destination]["temperature"],

        "humidity" =>
            $weatherData[$destination]["humidity"]

    ]);

} else {

    echo json_encode([

        "success" => false

    ]);

}

?>