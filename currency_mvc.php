<?php

session_start();

require_once 'models/Currency.php';
require_once 'controllers/CurrencyController.php';


$currencyModel = new Currency();

$currencyController =
    new CurrencyController($currencyModel);


$action = $_GET["action"] ?? "index";


switch ($action) {

    case "index":

        $currencyController->index();

        break;


    case "convert":

        $currencyController->convert();

        break;


    default:

        $currencyController->index();

        break;
}

?>