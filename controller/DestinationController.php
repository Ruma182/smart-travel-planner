
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Destination.php';


class DestinationController
{
    private $destination;


    public function __construct($conn)
    {
        $this->destination = new Destination($conn);
    }


    // ========================================
    // SHOW ALL DESTINATIONS
    // ========================================

    public function index()
    {
        if (!isset($_SESSION["user_id"])) {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }

        $result = $this->destination->getAll();

        require __DIR__ . '/../views/destinations/index.php';
    }


    // ========================================
    // CREATE DESTINATION FORM
    // ========================================

    public function create()
    {
        if (!isset($_SESSION["user_id"])) {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }

        if ($_SESSION["role"] != "local_explorer") {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }

        require __DIR__ . '/../views/destinations/create.php';
    }


    // ========================================
    // STORE DESTINATION
    // ========================================

    public function store()
    {
        if (!isset($_SESSION["user_id"])) {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }

        if ($_SESSION["role"] != "local_explorer") {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header(
                "Location: /web-technology/smart-travel-planner/destination_mvc.php?action=create"
            );
            exit();
        }

        $name = trim($_POST["name"] ?? "");
        $location = trim($_POST["location"] ?? "");
        $description = trim($_POST["description"] ?? "");
        $estimated_cost = floatval(
            $_POST["estimated_cost"] ?? 0
        );


        if (
            empty($name) ||
            empty($location) ||
            empty($description) ||
            $estimated_cost < 0
        ) {
            die("Please provide valid destination information.");
        }


        $result = $this->destination->create(
            $name,
            $location,
            $description,
            $estimated_cost,
            ""
        );


        if ($result) {

            // Save করার পর Manage Local Destinations এ যাবে
            header(
                "Location: /web-technology/smart-travel-planner/destination_mvc.php?action=manage"
            );

            exit();

        } else {

            die("Failed to add destination.");

        }
    }


    // ========================================
    // SEARCH DESTINATIONS - AJAX
    // ========================================

    public function search()
    {
        if (!isset($_SESSION["user_id"])) {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }


        $search = trim($_GET["search"] ?? "");


        $result = $this->destination->search($search);


        $destinations = [];


        while ($row = mysqli_fetch_assoc($result)) {

            $destinations[] = [

                "destination_id" =>
                    $row["destination_id"],

                "name" =>
                    $row["name"],

                "location" =>
                    $row["location"],

                "description" =>
                    $row["description"],

                "estimated_cost" =>
                    $row["estimated_cost"]

            ];

        }


        header("Content-Type: application/json");

        echo json_encode($destinations);

        exit();
    }


    // ========================================
    // EDIT DESTINATION
    // ========================================

    public function edit()
    {
        if (!isset($_SESSION["user_id"])) {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }


        if ($_SESSION["role"] != "local_explorer") {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }


        $id = intval($_GET["edit"] ?? 0);


        if ($id <= 0) {
            header(
                "Location: /web-technology/smart-travel-planner/destination_mvc.php?action=manage"
            );
            exit();
        }


        $destination = $this->destination->getById($id);


        if (!$destination) {
            die("Destination not found.");
        }


        require __DIR__ . '/../views/destinations/edit.php';
    }


    // ========================================
    // UPDATE DESTINATION
    // ========================================

    public function update()
    {
        if (!isset($_SESSION["user_id"])) {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }


        if ($_SESSION["role"] != "local_explorer") {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }


        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header(
                "Location: /web-technology/smart-travel-planner/destination_mvc.php?action=manage"
            );
            exit();
        }


        $destination_id = intval(
            $_POST["destination_id"] ?? 0
        );

        $name = trim(
            $_POST["name"] ?? ""
        );

        $location = trim(
            $_POST["location"] ?? ""
        );

        $description = trim(
            $_POST["description"] ?? ""
        );

        $estimated_cost = floatval(
            $_POST["estimated_cost"] ?? 0
        );


        if (
            $destination_id <= 0 ||
            empty($name) ||
            empty($location) ||
            empty($description) ||
            $estimated_cost < 0
        ) {
            die("Please provide valid destination information.");
        }


        $result = $this->destination->update(
            $destination_id,
            $name,
            $location,
            $description,
            $estimated_cost
        );


        if ($result) {

            header(
                "Location: /web-technology/smart-travel-planner/destination_mvc.php?action=manage"
            );

            exit();

        } else {

            die("Failed to update destination.");

        }
    }


    // ========================================
    // DELETE DESTINATION
    // ========================================

    public function delete()
    {
        if (!isset($_SESSION["user_id"])) {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }


        if ($_SESSION["role"] != "local_explorer") {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }


        $id = intval(
            $_GET["delete"] ?? 0
        );


        if ($id <= 0) {
            header(
                "Location: /web-technology/smart-travel-planner/destination_mvc.php?action=manage"
            );
            exit();
        }


        $result = $this->destination->delete($id);


        if ($result) {

            header(
                "Location: /web-technology/smart-travel-planner/destination_mvc.php?action=manage"
            );

            exit();

        } else {

            die("Failed to delete destination.");

        }
    }


    // ========================================
    // MANAGE DESTINATIONS
    // ========================================

    public function manage()
    {
        if (!isset($_SESSION["user_id"])) {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }


        if ($_SESSION["role"] != "local_explorer") {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }


        $result = $this->destination->getAll();


        require __DIR__ . '/../views/destinations/manage.php';
    }
}

?>

