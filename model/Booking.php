
<?php

class Booking
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    // Get Hotel and Transport Services
    public function getBookableServices()
    {
        $query = "SELECT *
                  FROM services
                  WHERE service_type = 'Hotel'
                  OR service_type = 'Transport'
                  ORDER BY service_id DESC";

        return mysqli_query($this->conn, $query);
    }


    // Get one service by ID
    public function getServiceById($service_id)
    {
        $query = "SELECT *
                  FROM services
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

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }


    // Create a booking
    public function create(
        $traveler_id,
        $provider_id,
        $service_type,
        $service_name,
        $booking_date,
        $number_of_people,
        $total_price
    ) {

        $query = "INSERT INTO bookings
        (
            traveler_id,
            provider_id,
            service_type,
            service_name,
            booking_date,
            number_of_people,
            total_price,
            status
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";


        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );


        mysqli_stmt_bind_param(
            $stmt,
            "iisssid",
            $traveler_id,
            $provider_id,
            $service_type,
            $service_name,
            $booking_date,
            $number_of_people,
            $total_price
        );


        return mysqli_stmt_execute($stmt);
    }


    // Get all bookings of a traveler
    public function getByTraveler($traveler_id)
    {
        $query = "SELECT *
                  FROM bookings
                  WHERE traveler_id = ?
                  ORDER BY booking_id DESC";

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

