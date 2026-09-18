
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/TravelTip.php';


class TravelTipController
{
    private $travelTip;


    public function __construct($conn)
    {
        $this->travelTip = new TravelTip($conn);
    }


    // ========================================
    // ADD TRAVEL TIP FORM
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


        require __DIR__ . '/../views/travel_tips/create.php';
    }


    // ========================================
    // STORE TRAVEL TIP
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
                "Location: /web-technology/smart-travel-planner/travel_tip_mvc.php?action=create"
            );
            exit();
        }


        $title = trim($_POST["title"] ?? "");
        $description = trim($_POST["description"] ?? "");

        $user_id = $_SESSION["user_id"];


        // ========================================
        // VALIDATION
        // ========================================

        if (
            empty($title) ||
            empty($description)
        ) {

            die("Please fill in all fields.");

        }


        // ========================================
        // CREATE TRAVEL TIP
        // ========================================

        $result = $this->travelTip->create(
            $user_id,
            $title,
            $description
        );


        if ($result) {

            header(
                "Location: /web-technology/smart-travel-planner/travel_tip_mvc.php?action=manage"
            );

            exit();

        } else {

            die("Failed to add travel tip.");

        }
    }


    // ========================================
    // SHOW ALL TRAVEL TIPS
    // ========================================

    public function index()
    {
        if (!isset($_SESSION["user_id"])) {
            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );
            exit();
        }


        $result = $this->travelTip->getAll();


        require __DIR__ . '/../views/travel_tips/index.php';
    }


    // ========================================
    // SHOW MY TRAVEL TIPS
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


        $user_id = $_SESSION["user_id"];


        $result = $this->travelTip->getByUser(
            $user_id
        );


        require __DIR__ . '/../views/travel_tips/manage.php';
    }


    // ========================================
    // EDIT TRAVEL TIP
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


        $tip_id = intval(
            $_GET["edit"] ?? 0
        );


        if ($tip_id <= 0) {
            header(
                "Location: /web-technology/smart-travel-planner/travel_tip_mvc.php?action=manage"
            );
            exit();
        }


        $destination = $this->travelTip->getById(
            $tip_id
        );


        if (!$destination) {
            die("Travel tip not found.");
        }


        // Only the owner can edit the tip

        if (
            $destination["user_id"]
            != $_SESSION["user_id"]
        ) {

            die("You are not allowed to edit this travel tip.");

        }


        $tip = $destination;


        require __DIR__ . '/../views/travel_tips/edit.php';
    }


    // ========================================
    // UPDATE TRAVEL TIP
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
                "Location: /web-technology/smart-travel-planner/travel_tip_mvc.php?action=manage"
            );
            exit();
        }


        $tip_id = intval(
            $_POST["tip_id"] ?? 0
        );

        $title = trim(
            $_POST["title"] ?? ""
        );

        $description = trim(
            $_POST["description"] ?? ""
        );


        if (
            $tip_id <= 0 ||
            empty($title) ||
            empty($description)
        ) {

            die("Please provide valid travel tip information.");

        }


        // Check ownership

        $tip = $this->travelTip->getById(
            $tip_id
        );


        if (!$tip) {
            die("Travel tip not found.");
        }


        if (
            $tip["user_id"]
            != $_SESSION["user_id"]
        ) {

            die("You are not allowed to update this travel tip.");

        }


        $result = $this->travelTip->update(
            $tip_id,
            $title,
            $description
        );


        if ($result) {

            header(
                "Location: /web-technology/smart-travel-planner/travel_tip_mvc.php?action=manage"
            );

            exit();

        } else {

            die("Failed to update travel tip.");

        }
    }


    // ========================================
    // DELETE TRAVEL TIP
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


        $tip_id = intval(
            $_GET["delete"] ?? 0
        );


        if ($tip_id <= 0) {
            header(
                "Location: /web-technology/smart-travel-planner/travel_tip_mvc.php?action=manage"
            );
            exit();
        }


        // Check ownership

        $tip = $this->travelTip->getById(
            $tip_id
        );


        if (!$tip) {
            die("Travel tip not found.");
        }


        if (
            $tip["user_id"]
            != $_SESSION["user_id"]
        ) {

            die("You are not allowed to delete this travel tip.");

        }


        $result = $this->travelTip->delete(
            $tip_id
        );


        if ($result) {

            header(
                "Location: /web-technology/smart-travel-planner/travel_tip_mvc.php?action=manage"
            );

            exit();

        } else {

            die("Failed to delete travel tip.");

        }
    }
}

?>

