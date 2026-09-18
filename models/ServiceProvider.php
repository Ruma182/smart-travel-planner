<?php

class ServiceProvider
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // =========================
    // ADD SERVICE
    // =========================

    public function createService(
        $provider_id,
        $service_type,
        $service_name,
        $location,
        $description,
        $price
    ) {
        $query = "INSERT INTO services
        (
            provider_id,
            service_type,
            service_name,
            location,
            description,
            price
        )
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "issssd",
            $provider_id,
            $service_type,
            $service_name,
            $location,
            $description,
            $price
        );

        return mysqli_stmt_execute($stmt);
    }


    // =========================
    // GET MY SERVICES
    // =========================

    public function getMyServices($provider_id)
    {
        $query = "SELECT *
                  FROM services
                  WHERE provider_id = ?
                  ORDER BY service_id DESC";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $provider_id
        );

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }


    // =========================
    // GET SERVICE BY ID
    // =========================

    public function getServiceById(
        $service_id,
        $provider_id
    ) {
        $query = "SELECT *
                  FROM services
                  WHERE service_id = ?
                  AND provider_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $service_id,
            $provider_id
        );

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }


    // =========================
    // UPDATE SERVICE
    // =========================

    public function updateService(
        $service_id,
        $provider_id,
        $service_type,
        $service_name,
        $location,
        $description,
        $price
    ) {
        $query = "UPDATE services
                  SET
                    service_type = ?,
                    service_name = ?,
                    location = ?,
                    description = ?,
                    price = ?
                  WHERE service_id = ?
                  AND provider_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssssdii",
            $service_type,
            $service_name,
            $location,
            $description,
            $price,
            $service_id,
            $provider_id
        );

        return mysqli_stmt_execute($stmt);
    }


    // =========================
    // DELETE SERVICE
    // =========================

    public function deleteService(
        $service_id,
        $provider_id
    ) {
        $query = "DELETE FROM services
                  WHERE service_id = ?
                  AND provider_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $service_id,
            $provider_id
        );

        return mysqli_stmt_execute($stmt);
    }


    // =========================
    // GET BOOKING REQUESTS
    // =========================

    public function getBookingRequests($provider_id)
    {
        $query = "SELECT bookings.*,
                         users.name AS traveler_name
                  FROM bookings
                  JOIN users
                  ON bookings.traveler_id = users.user_id
                  WHERE bookings.provider_id = ?
                  ORDER BY bookings.booking_id DESC";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $provider_id
        );

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }


    // =========================
    // UPDATE BOOKING STATUS
    // =========================

    public function updateBookingStatus(
        $booking_id,
        $provider_id,
        $status
    ) {
        $query = "UPDATE bookings
                  SET status = ?
                  WHERE booking_id = ?
                  AND provider_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sii",
            $status,
            $booking_id,
            $provider_id
        );

        return mysqli_stmt_execute($stmt);
    }


    // =========================
    // GET CUSTOMER FEEDBACK
    // =========================

    public function getCustomerFeedback($provider_id)
    {
        $query = "
            SELECT
                reviews.review_id,
                reviews.rating,
                reviews.review_text,
                reviews.created_at,

                destinations.name AS destination_name,

                users.name AS traveler_name,

                services.service_name

            FROM reviews

            JOIN destinations
                ON reviews.destination_id =
                   destinations.destination_id

            JOIN users
                ON reviews.traveler_id =
                   users.user_id

            JOIN services
                ON reviews.service_id =
                   services.service_id

            WHERE services.provider_id = ?

            ORDER BY reviews.review_id DESC
        ";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $provider_id
        );

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }
}

?>