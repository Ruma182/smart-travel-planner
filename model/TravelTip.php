
<?php

class TravelTip
{
    private $conn;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    // =========================
    // GET ALL TRAVEL TIPS
    // =========================

    public function getAll()
    {
        $query = "SELECT *
                  FROM travel_tips
                  ORDER BY tip_id DESC";

        $result = mysqli_query(
            $this->conn,
            $query
        );

        return $result;
    }


    // =========================
    // GET MY TRAVEL TIPS
    // =========================

    public function getByUser($user_id)
    {
        $query = "SELECT *
                  FROM travel_tips
                  WHERE user_id = ?
                  ORDER BY tip_id DESC";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $user_id
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return $result;
    }


    // =========================
    // GET TIP BY ID
    // =========================

    public function getById($tip_id)
    {
        $query = "SELECT *
                  FROM travel_tips
                  WHERE tip_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $tip_id
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }


    // =========================
    // CREATE TRAVEL TIP
    // =========================

    public function create(
        $user_id,
        $title,
        $description
    ) {

        $query = "INSERT INTO travel_tips
                  (user_id, title, description)
                  VALUES (?, ?, ?)";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "iss",
            $user_id,
            $title,
            $description
        );

        return mysqli_stmt_execute($stmt);
    }


    // =========================
    // UPDATE TRAVEL TIP
    // =========================

    public function update(
        $tip_id,
        $title,
        $description
    ) {

        $query = "UPDATE travel_tips
                  SET title = ?,
                      description = ?
                  WHERE tip_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssi",
            $title,
            $description,
            $tip_id
        );

        return mysqli_stmt_execute($stmt);
    }


    // =========================
    // DELETE TRAVEL TIP
    // =========================

    public function delete($tip_id)
    {
        $query = "DELETE FROM travel_tips
                  WHERE tip_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $tip_id
        );

        return mysqli_stmt_execute($stmt);
    }
}

?>

