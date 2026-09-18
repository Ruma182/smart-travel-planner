<?php

class BookingController
{
    private $booking;

    public function __construct($conn)
    {
        require_once __DIR__ . '/../models/Booking.php';

        $this->booking = new Booking($conn);
    }

    // Check Traveler Login
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

    // Show Booking Page
    public function create()
    {
        $this->checkTraveler();

        $result = $this->booking->getBookableServices();

        require __DIR__ . '/../views/bookings/create.php';
    }

    // Save Booking
    public function store()
    {
        $this->checkTraveler();

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header(
                "Location: /web-technology/smart-travel-planner/booking_mvc.php"
            );
            exit();
        }

        $traveler_id = $_SESSION["user_id"];

        $service_id = $_POST["service_id"];
        $booking_date = $_POST["booking_date"];
        $number_of_people = $_POST["number_of_people"];

        // Get selected service
        $result = $this->booking->getServiceById($service_id);

        if (mysqli_num_rows($result) == 0) {
            echo "<script>
                    alert('Service not found!');
                    window.location.href='/web-technology/smart-travel-planner/booking_mvc.php';
                  </script>";
            exit();
        }

        $service = mysqli_fetch_assoc($result);

        $provider_id = $service["provider_id"];
        $service_type = $service["service_type"];
        $service_name = $service["service_name"];
        $price = $service["price"];

        // Calculate total price
        $total_price = $price * $number_of_people;

        // Save booking
        $success = $this->booking->create(
            $traveler_id,
            $provider_id,
            $service_type,
            $service_name,
            $booking_date,
            $number_of_people,
            $total_price
        );

        if ($success) {

            echo "<script>
                    alert('Booking Successful!');
                    window.location.href='/web-technology/smart-travel-planner/booking_mvc.php?action=my_bookings';
                  </script>";

        } else {

            echo "<script>
                    alert('Error saving booking!');
                    window.location.href='/web-technology/smart-travel-planner/booking_mvc.php';
                  </script>";
        }
    }

    // Show My Bookings
    public function index()
    {
        $this->checkTraveler();

        $traveler_id = $_SESSION["user_id"];

        $result = $this->booking->getByTraveler($traveler_id);

        require __DIR__ . '/../views/bookings/index.php';
    }
}

?>