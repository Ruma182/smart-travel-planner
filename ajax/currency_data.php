<?php

header("Content-Type: application/json");


$amount = isset($_GET["amount"])
    ? floatval($_GET["amount"])
    : 0;

$from = isset($_GET["from"])
    ? $_GET["from"]
    : "";

$to = isset($_GET["to"])
    ? $_GET["to"]
    : "";


$rates = [

    "BDT" => [
        "BDT" => 1,
        "USD" => 0.0082,
        "EUR" => 0.0075
    ],

    "USD" => [
        "BDT" => 122,
        "USD" => 1,
        "EUR" => 0.91
    ],

    "EUR" => [
        "BDT" => 133,
        "USD" => 1.10,
        "EUR" => 1
    ]

];


if (

    $amount > 0

    &&

    isset($rates[$from])

    &&

    isset($rates[$from][$to])

) {

    $convertedAmount =
        $amount * $rates[$from][$to];


    echo json_encode([

        "success" => true,

        "amount" => $amount,

        "from" => $from,

        "result" =>
            round($convertedAmount, 2),

        "to" => $to

    ]);

} else {

    echo json_encode([

        "success" => false

    ]);

}

?>