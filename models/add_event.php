<?php

class LocalEvent
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    // =========================
    // CREATE EVENT
    // =========================

    public function createEvent(
        $user_id,
        $event_name,
        $location,
        $event_date,
        $description
    ) {

        $query = "INSERT INTO local_events
        (
            user_id,
            event_name,
            location,
            event_date,
            description
        )
        VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "issss",
            $user_id,
            $event_name,
            $location,
            $event_date,
            $description
        );

        return mysqli_stmt_execute($stmt);
    }


    // =========================
    // GET MY EVENTS
    // =========================

    public function getMyEvents($user_id)
    {
        $query = "SELECT *
                  FROM local_events
                  WHERE user_id = ?
                  ORDER BY event_id DESC";

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

        return mysqli_stmt_get_result($stmt);
    }


    // =========================
    // GET EVENT BY ID
    // =========================

    public function getEventById(
        $event_id,
        $user_id
    ) {

        $query = "SELECT *
                  FROM local_events
                  WHERE event_id = ?
                  AND user_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $event_id,
            $user_id
        );

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }


    // =========================
    // UPDATE EVENT
    // =========================

    public function updateEvent(
        $event_id,
        $user_id,
        $event_name,
        $location,
        $event_date,
        $description
    ) {

        $query = "UPDATE local_events
                  SET
                    event_name = ?,
                    location = ?,
                    event_date = ?,
                    description = ?
                  WHERE event_id = ?
                  AND user_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssssii",
            $event_name,
            $location,
            $event_date,
            $description,
            $event_id,
            $user_id
        );

        return mysqli_stmt_execute($stmt);
    }


    // =========================
    // DELETE EVENT
    // =========================

    public function deleteEvent(
        $event_id,
        $user_id
    ) {

        $query = "DELETE FROM local_events
                  WHERE event_id = ?
                  AND user_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $event_id,
            $user_id
        );

        return mysqli_stmt_execute($stmt);
    }
}

?>
