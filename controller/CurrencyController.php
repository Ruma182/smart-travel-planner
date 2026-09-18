<?php

class CurrencyController
{
    private $currency;


    public function __construct($currency)
    {
        $this->currency = $currency;
    }


    /* =========================
       TRAVELER CHECK
    ========================= */

    private function checkTraveler()
    {
        if (!isset($_SESSION["user_id"])) {

            header("Location: login.php");
            exit();

        }

        if ($_SESSION["role"] != "traveler") {

            header("Location: login.php");
            exit();

        }
    }


    /* =========================
       CURRENCY PAGE
    ========================= */

    public function index()
    {
        $this->checkTraveler();

        require __DIR__ . "/../views/currency/index.php";
    }


    /* =========================
       CURRENCY AJAX
    ========================= */

    public function convert()
    {
        $this->checkTraveler();

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


        $result =
            $this->currency->convert(
                $amount,
                $from,
                $to
            );


        echo json_encode($result);

        exit();
    }
}

?>