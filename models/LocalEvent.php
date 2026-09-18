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
        $explorer_id,
        $event_name,
        $location,
        $event_date,
        $description
    ) {

        $query = "INSERT INTO events
        (
            explorer_id,
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
            $explorer_id,
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

    public function getMyEvents($explorer_id)
    {
        $query = "SELECT *
                  FROM events
                  WHERE explorer_id = ?
                  ORDER BY event_id DESC";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $explorer_id
        );

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }


    // =========================
    // GET EVENT BY ID
    // =========================

    public function getEventById(
        $event_id,
        $explorer_id
    ) {

        $query = "SELECT *
                  FROM events
                  WHERE event_id = ?
                  AND explorer_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $event_id,
            $explorer_id
        );

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }


    // =========================
    // UPDATE EVENT
    // =========================

    public function updateEvent(
        $event_id,
        $explorer_id,
        $event_name,
        $location,
        $event_date,
        $description
    ) {

        $query = "UPDATE events
                  SET
                    event_name = ?,
                    location = ?,
                    event_date = ?,
                    description = ?
                  WHERE event_id = ?
                  AND explorer_id = ?";

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
            $explorer_id
        );

        return mysqli_stmt_execute($stmt);
    }


    // =========================
    // DELETE EVENT
    // =========================

    public function deleteEvent(
        $event_id,
        $explorer_id
    ) {

        $query = "DELETE FROM events
                  WHERE event_id = ?
                  AND explorer_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $event_id,
            $explorer_id
        );

        return mysqli_stmt_execute($stmt);
    }
}

?>