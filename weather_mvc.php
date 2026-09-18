<?php

session_start();

require_once 'models/Weather.php';
require_once 'controllers/WeatherController.php';


$weatherModel = new Weather();

$weatherController =
    new WeatherController($weatherModel);


$action = $_GET["action"] ?? "index";


switch ($action) {

    case "index":

        $weatherController->index();

        break;


    case "get_weather":

        $weatherController->getWeather();

        break;


    default:

        $weatherController->index();

        break;
}

?>