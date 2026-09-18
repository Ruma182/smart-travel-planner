<?php

class AdminController
{
    private $admin;


    // =========================
    // CONSTRUCTOR
    // =========================

    public function __construct($conn)
    {
        require_once __DIR__ . '/../models/Admin.php';

        $this->admin = new Admin($conn);
    }


    // =========================
    // ADMIN CHECK
    // =========================

    private function checkAdmin()
    {
        if (!isset($_SESSION["user_id"])) {

            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );

            exit();
        }


        if ($_SESSION["role"] !== "admin") {

            header(
                "Location: /web-technology/smart-travel-planner/login.php"
            );

            exit();
        }
    }


    // =========================
    // ADMIN DASHBOARD
    // =========================

    public function dashboard()
    {
        $this->checkAdmin();

        require __DIR__ . '/../views/admin/dashboard.php';
    }


    // =========================
    // MANAGE USERS
    // =========================

    public function users()
    {
        $this->checkAdmin();

        $result = $this->admin->getAllUsers();

        require __DIR__ . '/../views/admin/users.php';
    }


    // =========================
    // MANAGE DESTINATIONS
    // =========================

    public function destinations()
    {
        $this->checkAdmin();


        // DELETE DESTINATION

        if (isset($_GET["delete"])) {

            $destination_id = $_GET["delete"];

            $this->admin->deleteDestination(
                $destination_id
            );

            header(
                "Location: /web-technology/smart-travel-planner/admin_mvc.php?action=destinations"
            );

            exit();
        }


        // UPDATE DESTINATION

        if (
            $_SERVER["REQUEST_METHOD"] === "POST"
            &&
            isset($_POST["update_destination"])
        ) {

            $destination_id =
                $_POST["destination_id"];

            $name =
                trim($_POST["name"]);

            $location =
                trim($_POST["location"]);

            $description =
                trim($_POST["description"]);

            $estimated_cost =
                $_POST["estimated_cost"];


            $this->admin->updateDestination(
                $destination_id,
                $name,
                $location,
                $description,
                $estimated_cost
            );


            header(
                "Location: /web-technology/smart-travel-planner/admin_mvc.php?action=destinations"
            );

            exit();
        }


        $result =
            $this->admin->getAllDestinations();


        require __DIR__ . '/../views/admin/destinations.php';
    }


    // =========================
    // MANAGE SERVICES
    // =========================

    public function services()
    {
        $this->checkAdmin();

        $result =
            $this->admin->getAllServices();

        require __DIR__ . '/../views/admin/services.php';
    }


    // =========================
    // MANAGE BOOKINGS
    // =========================

    public function bookings()
    {
        $this->checkAdmin();

        $result =
            $this->admin->getAllBookings();

        require __DIR__ . '/../views/admin/bookings.php';
    }


    // =========================
    // MANAGE REVIEWS
    // =========================

    public function reviews()
    {
        $this->checkAdmin();


        // DELETE REVIEW

        if (isset($_GET["delete"])) {

            $review_id =
                $_GET["delete"];


            $this->admin->deleteReview(
                $review_id
            );


            header(
                "Location: /web-technology/smart-travel-planner/admin_mvc.php?action=reviews"
            );

            exit();
        }


        $result =
            $this->admin->getAllReviews();


        require __DIR__ . '/../views/admin/reviews.php';
    }


    // =========================
    // REPORTS
    // =========================

    public function reports()
    {
        $this->checkAdmin();

        $reports =
            $this->admin->getReports();


        require __DIR__ . '/../views/admin/reports.php';
    }


    // =========================
    // TOGGLE USER STATUS
    // =========================

    public function toggleUserStatus()
    {
        $this->checkAdmin();


        $user_id =
            $_GET["id"] ?? 0;


        $this->admin->toggleUserStatus(
            $user_id
        );


        header(
            "Location: /web-technology/smart-travel-planner/admin_mvc.php?action=users"
        );

        exit();
    }


    // =========================
    // DELETE SERVICE
    // =========================

    public function deleteService()
    {
        $this->checkAdmin();


        $service_id =
            $_GET["id"] ?? 0;


        $this->admin->deleteService(
            $service_id
        );


        header(
            "Location: /web-technology/smart-travel-planner/admin_mvc.php?action=services"
        );

        exit();
    }


    // =========================
    // APPROVE BOOKING
    // =========================

    public function approveBooking()
    {
        $this->checkAdmin();


        $booking_id =
            $_GET["booking_id"] ?? 0;


        $this->admin->updateBookingStatus(
            $booking_id,
            "confirmed"
        );


        header(
            "Location: /web-technology/smart-travel-planner/admin_mvc.php?action=bookings"
        );

        exit();
    }


    // =========================
    // REJECT BOOKING
    // =========================

    public function rejectBooking()
    {
        $this->checkAdmin();


        $booking_id =
            $_GET["booking_id"] ?? 0;


        $this->admin->updateBookingStatus(
            $booking_id,
            "rejected"
        );


        header(
            "Location: /web-technology/smart-travel-planner/admin_mvc.php?action=bookings"
        );

        exit();
    }
}

?>