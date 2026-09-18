<?php

class ReviewController
{
    private $review;

    public function __construct($review)
    {
        $this->review = $review;
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
       ADD REVIEW PAGE
    ========================= */

    public function create()
    {
        $this->checkTraveler();

        $destination_result =
            $this->review->getDestinations();

        $service_result =
            $this->review->getServices();
          require __DIR__ . "/../views/reviews/create.php";
    }


    /* =========================
       SAVE REVIEW
    ========================= */

    public function store()
    {
        $this->checkTraveler();

        if ($_SERVER["REQUEST_METHOD"] != "POST") {

            header(
                "Location: review_mvc.php?action=create"
            );

            exit();
        }


        $traveler_id = $_SESSION["user_id"];

        $destination_id = intval(
            $_POST["destination_id"]
        );

        $service_id = intval(
            $_POST["service_id"]
        );

        $rating = intval(
            $_POST["rating"]
        );

        $review_text = trim(
            $_POST["review_text"]
        );


        /* =========================
           VALIDATION
        ========================= */

        if (
            $destination_id <= 0 ||
            $service_id <= 0 ||
            $rating < 1 ||
            $rating > 5 ||
            empty($review_text)
        ) {

            die(
                "Please provide a valid destination, service, rating and review."
            );
        }


        /* =========================
           CHECK SERVICE
        ========================= */

        if (
            !$this->review->serviceExists(
                $service_id
            )
        ) {

            die(
                "Invalid service selected."
            );
        }


        /* =========================
           INSERT REVIEW
        ========================= */

        if (
            $this->review->create(
                $traveler_id,
                $destination_id,
                $service_id,
                $rating,
                $review_text
            )
        ) {

            header(
                "Location: review_mvc.php?action=my_reviews"
            );

            exit();

        } else {

            die(
                "Failed to submit review."
            );
        }
    }


    /* =========================
       MY REVIEWS
    ========================= */

    public function index()
    {
        $this->checkTraveler();

        $traveler_id =
            $_SESSION["user_id"];

        $result =
            $this->review->getByTraveler(
                $traveler_id
            );

        require __DIR__ . "/../views/reviews/index.php";
    }
}

?>