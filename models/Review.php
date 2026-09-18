
<?php

class Review
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    // ==============================
    // GET ALL DESTINATIONS
    // ==============================

    public function getDestinations()
    {
        $query = "
            SELECT destination_id, name
            FROM destinations
            ORDER BY name ASC
        ";

        return mysqli_query($this->conn, $query);
    }


    // ==============================
    // GET ALL SERVICES
    // ==============================

    public function getServices()
    {
        $query = "
            SELECT service_id, service_name
            FROM services
            ORDER BY service_name ASC
        ";

        return mysqli_query($this->conn, $query);
    }


    // ==============================
    // CHECK SERVICE EXISTS
    // ==============================

    public function serviceExists($service_id)
    {
        $query = "
            SELECT service_id
            FROM services
            WHERE service_id = ?
        ";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $service_id
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $exists = mysqli_num_rows($result) > 0;

        mysqli_stmt_close($stmt);

        return $exists;
    }


    // ==============================
    // CREATE REVIEW
    // ==============================

    public function create(
        $traveler_id,
        $destination_id,
        $service_id,
        $rating,
        $review_text
    ) {
        $query = "
            INSERT INTO reviews
            (
                traveler_id,
                destination_id,
                service_id,
                rating,
                review_text
            )
            VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "iiiis",
            $traveler_id,
            $destination_id,
            $service_id,
            $rating,
            $review_text
        );

        $result = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        return $result;
    }


    // ==============================
    // GET TRAVELER'S REVIEWS
    // ==============================

    public function getByTraveler($traveler_id)
    {
        $query = "
            SELECT
                reviews.review_id,
                reviews.rating,
                reviews.review_text,
                reviews.created_at,

                destinations.name AS destination_name,

                services.service_name

            FROM reviews

            JOIN destinations
                ON reviews.destination_id =
                   destinations.destination_id

            JOIN services
                ON reviews.service_id =
                   services.service_id

            WHERE reviews.traveler_id = ?

            ORDER BY reviews.review_id DESC
        ";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $traveler_id
        );

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }
}

?>

