<?php

class Admin
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


public function getAllUsers()
    {
        $query = "SELECT
                    user_id,
                    name,
                    email,
                    role,
                    status,
                    created_at
                  FROM users
                  ORDER BY user_id DESC";

        return mysqli_query(
            $this->conn,
            $query
        );
    }



    public function getAllDestinations()
    {
        $query = "SELECT
                    destination_id,
                    name,
                    location,
                    description,
                    estimated_cost,
                    created_at
                  FROM destinations
                  ORDER BY destination_id DESC";

        return mysqli_query(
            $this->conn,
            $query
        );
    }



    public function updateDestination(
        $destination_id,
        $name,
        $location,
        $description,
        $estimated_cost
    ) {

        $query = "UPDATE destinations
                  SET
                    name = ?,
                    location = ?,
                    description = ?,
                    estimated_cost = ?
                  WHERE destination_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssdi",
            $name,
            $location,
            $description,
            $estimated_cost,
            $destination_id
        );

        return mysqli_stmt_execute($stmt);
    }



    public function deleteDestination(
        $destination_id
    ) {

        $query = "DELETE FROM destinations
                  WHERE destination_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $destination_id
        );

        return mysqli_stmt_execute($stmt);
    }


   public function getAllServices()
    {
        $query = "SELECT
                    services.*,
                    users.name AS provider_name,
                    users.email AS provider_email
                  FROM services
                  JOIN users
                  ON services.provider_id = users.user_id
                  ORDER BY services.service_id DESC";

        return mysqli_query(
            $this->conn,
            $query
        );
    }



    public function deleteService(
        $service_id
    ) {

        $query = "DELETE FROM services
                  WHERE service_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $service_id
        );

        return mysqli_stmt_execute($stmt);
    }


    // =========================
    // GET ALL BOOKINGS
    // =========================

    public function getAllBookings()
    {
        $query = "SELECT *
                  FROM bookings
                  ORDER BY booking_id DESC";

        return mysqli_query(
            $this->conn,
            $query
        );
    }


    // =========================
    // UPDATE BOOKING STATUS
    // =========================

    public function updateBookingStatus(
        $booking_id,
        $status
    ) {

        $query = "UPDATE bookings
                  SET status = ?
                  WHERE booking_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $status,
            $booking_id
        );

        return mysqli_stmt_execute($stmt);
    }


    // =========================
    // GET ALL REVIEWS
    // =========================

    public function getAllReviews()
    {
        $query = "SELECT *
                  FROM reviews
                  ORDER BY review_id DESC";

        return mysqli_query(
            $this->conn,
            $query
        );
    }


    // =========================
    // DELETE REVIEW
    // =========================

    public function deleteReview(
        $review_id
    ) {

        $query = "DELETE FROM reviews
                  WHERE review_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $review_id
        );

        return mysqli_stmt_execute($stmt);
    }

// =========================
// TOGGLE USER STATUS
// =========================

public function toggleUserStatus($user_id)
{
    $query = "UPDATE users
              SET status =
                  CASE
                      WHEN status = 'active'
                      THEN 'inactive'
                      ELSE 'active'
                  END
              WHERE user_id = ?";

    $stmt = mysqli_prepare(
        $this->conn,
        $query
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $user_id
    );

    return mysqli_stmt_execute($stmt);
}
    // =========================
    // REPORTS & ANALYTICS
    // =========================

    public function getReports()
    {
        $reports = [];


        // Total Users

        $query = "SELECT COUNT(*) AS total
                  FROM users";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["total_users"] =
            mysqli_fetch_assoc($result)["total"];


        // Travelers

        $query = "SELECT COUNT(*) AS total
                  FROM users
                  WHERE role = 'traveler'";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["total_travelers"] =
            mysqli_fetch_assoc($result)["total"];


        // Service Providers

        $query = "SELECT COUNT(*) AS total
                  FROM users
                  WHERE role = 'service_provider'";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["total_providers"] =
            mysqli_fetch_assoc($result)["total"];


        // Local Explorers

        $query = "SELECT COUNT(*) AS total
                  FROM users
                  WHERE role = 'local_explorer'";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["total_local_explorers"] =
            mysqli_fetch_assoc($result)["total"];


        // Active Users

        $query = "SELECT COUNT(*) AS total
                  FROM users
                  WHERE status = 'active'";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["active_users"] =
            mysqli_fetch_assoc($result)["total"];


        // Destinations

        $query = "SELECT COUNT(*) AS total
                  FROM destinations";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["total_destinations"] =
            mysqli_fetch_assoc($result)["total"];


        // Services

        $query = "SELECT COUNT(*) AS total
                  FROM services";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["total_services"] =
            mysqli_fetch_assoc($result)["total"];


        // Total Bookings

        $query = "SELECT COUNT(*) AS total
                  FROM bookings";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["total_bookings"] =
            mysqli_fetch_assoc($result)["total"];


        // Pending Bookings

        $query = "SELECT COUNT(*) AS total
                  FROM bookings
                  WHERE status = 'pending'";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["pending_bookings"] =
            mysqli_fetch_assoc($result)["total"];


        // Confirmed Bookings

        $query = "SELECT COUNT(*) AS total
                  FROM bookings
                  WHERE status = 'confirmed'";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["confirmed_bookings"] =
            mysqli_fetch_assoc($result)["total"];


        // Rejected Bookings

        $query = "SELECT COUNT(*) AS total
                  FROM bookings
                  WHERE status = 'rejected'";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["rejected_bookings"] =
            mysqli_fetch_assoc($result)["total"];


        // Total Revenue

        $query = "SELECT COALESCE(
                    SUM(total_price),
                    0
                  ) AS total
                  FROM bookings
                  WHERE status = 'confirmed'";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["total_revenue"] =
            mysqli_fetch_assoc($result)["total"];


        // Total Reviews

        $query = "SELECT COUNT(*) AS total
                  FROM reviews";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["total_reviews"] =
            mysqli_fetch_assoc($result)["total"];


        // Average Rating

        $query = "SELECT COALESCE(
                    AVG(rating),
                    0
                  ) AS average
                  FROM reviews";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        $reports["average_rating"] =
            mysqli_fetch_assoc($result)["average"];


        return $reports;
    }
}

?>