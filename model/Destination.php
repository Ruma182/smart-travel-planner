
<?php

class Destination
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    // =========================
    // GET ALL DESTINATIONS
    // =========================

    public function getAll()
    {
        $query = "SELECT * FROM destinations ORDER BY name ASC";

        $result = mysqli_query($this->conn, $query);

        return $result;
    }


    // =========================
    // GET DESTINATION BY ID
    // =========================

    public function getById($id)
    {
        $query = "SELECT * FROM destinations
                  WHERE destination_id = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $id
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }


    // =========================
    // CREATE DESTINATION
    // =========================

    public function create(
        $name,
        $location,
        $description,
        $estimated_cost,
        $image
    ) {
        $query = "INSERT INTO destinations
                  (name, location, description, estimated_cost, image)
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssds",
            $name,
            $location,
            $description,
            $estimated_cost,
            $image
        );

        return mysqli_stmt_execute($stmt);
    }


    // =========================
    // SEARCH DESTINATIONS
    // =========================

    public function search($search)
    {
        $query = "
            SELECT
                destination_id,
                name,
                location,
                description,
                estimated_cost
            FROM destinations
            WHERE name LIKE ?
               OR location LIKE ?
            ORDER BY destination_id DESC
        ";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        $searchValue = "%" . $search . "%";

        mysqli_stmt_bind_param(
            $stmt,
            "ss",
            $searchValue,
            $searchValue
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return $result;
    }


    // =========================
    // UPDATE DESTINATION
    // =========================

    public function update(
        $destination_id,
        $name,
        $location,
        $description,
        $estimated_cost
    ) {
        $query = "UPDATE destinations
                  SET name = ?,
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


    // =========================
    // DELETE DESTINATION
    // =========================

    public function delete($id)
    {
        $query = "DELETE FROM destinations
                  WHERE destination_id = ?";

        $stmt = mysqli_prepare(
            $this->conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $id
        );

        return mysqli_stmt_execute($stmt);
    }
}

?>

