
<?php

class TripPlanController
{
    private $tripPlan;

    public function __construct($conn)
    {
        require_once __DIR__ . '/../models/TripPlan.php';

        $this->tripPlan = new TripPlan($conn);
    }


    // Check traveler login
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


    // Show Trip Planner page
    public function create()
    {
        $this->checkTraveler();

        require __DIR__ . '/../views/trips/create.php';
    }


    // Save Trip Plan
    public function store()
    {
        $this->checkTraveler();

        if ($_SERVER["REQUEST_METHOD"] != "POST") {

            header(
                "Location: /web-technology/smart-travel-planner/trip_mvc.php"
            );

            exit();
        }


        $user_id = $_SESSION["user_id"];

        $destination = trim($_POST["destination"]);
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];

        $transport = $_POST["transport"];
        $hotel = $_POST["hotel"];
        $food = $_POST["food"];
        $other = $_POST["other"];

        $total_budget = $_POST["total_budget"];


        $success = $this->tripPlan->create(
            $user_id,
            $destination,
            $start_date,
            $end_date,
            $transport,
            $hotel,
            $food,
            $other,
            $total_budget
        );


        if ($success) {

            echo "<script>
                    alert('Trip Plan Saved Successfully!');
                    window.location.href='/web-technology/smart-travel-planner/trip_mvc.php?action=my_trips';
                  </script>";

        } else {

            echo "Error saving trip plan.";

        }
    }


    // Show My Trip Plans
    public function index()
    {
        $this->checkTraveler();

        $user_id = $_SESSION["user_id"];

        $result = $this->tripPlan->getByUser($user_id);

        require __DIR__ . '/../views/trips/index.php';
    }
}

?>

