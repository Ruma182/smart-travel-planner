
<?php

class TripPlan
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Get all trip plans of a traveler
    public function getByUser($user_id)
    {
        $query = "SELECT *
                  FROM trip_plans
                  WHERE user_id = ?
                  ORDER BY trip_id DESC";

        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $user_id
        );

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }


    // Save a new trip plan
    public function create(
        $user_id,
        $destination,
        $start_date,
        $end_date,
        $transport,
        $hotel,
        $food,
        $other,
        $total_budget
    ) {

        $query = "INSERT INTO trip_plans
        (
            user_id,
            destination,
            start_date,
            end_date,
            transport_cost,
            hotel_cost,
            food_cost,
            other_cost,
            total_budget
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "isssddddd",
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

        return mysqli_stmt_execute($stmt);
    }
}

?>

