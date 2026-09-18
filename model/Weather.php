<?php

class Weather
{
    private $weatherData;


    public function __construct()
    {
        $this->weatherData = [

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
    }


    /* =========================
       GET WEATHER
    ========================= */

    public function getWeather($destination)
    {
        $destination =
            strtolower(trim($destination));


        if (
            isset(
                $this->weatherData[$destination]
            )
        ) {

            return [

                "success" => true,

                "destination" =>
                    ucwords($destination),

                "condition" =>
                    $this->weatherData[$destination]["condition"],

                "temperature" =>
                    $this->weatherData[$destination]["temperature"],

                "humidity" =>
                    $this->weatherData[$destination]["humidity"]

            ];

        }


        return [

            "success" => false

        ];
    }
}

?>