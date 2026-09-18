<?php

class WeatherController
{
    private $weather;

    public function __construct($weather)
    {
        $this->weather = $weather;
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
       WEATHER PAGE
    ========================= */

    public function index()
    {
        $this->checkTraveler();

        require __DIR__ . "/../views/weather/index.php";
    }


    /* =========================
       WEATHER AJAX
    ========================= */

    public function getWeather()
    {
        $this->checkTraveler();

        header("Content-Type: application/json");

        $destination =
            isset($_GET["destination"])
            ? $_GET["destination"]
            : "";

        $result =
            $this->weather->getWeather(
                $destination
            );

        echo json_encode($result);

        exit();
    }
}

?>