
<?php

class Favorite
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getByUser($user_id)
    {
        $query = "SELECT *
                  FROM favorites
                  WHERE user_id = ?
                  ORDER BY favorite_id DESC";

        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }

    public function add($user_id, $destination_name)
    {
        $check_query = "SELECT favorite_id
                        FROM favorites
                        WHERE user_id = ?
                        AND destination_name = ?";

        $stmt = mysqli_prepare($this->conn, $check_query);

        mysqli_stmt_bind_param(
            $stmt,
            "is",
            $user_id,
            $destination_name
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            return false;
        }

        $insert_query = "INSERT INTO favorites
                         (user_id, destination_name)
                         VALUES (?, ?)";

        $stmt = mysqli_prepare($this->conn, $insert_query);

        mysqli_stmt_bind_param(
            $stmt,
            "is",
            $user_id,
            $destination_name
        );

        return mysqli_stmt_execute($stmt);
    }

    public function delete($favorite_id, $user_id)
    {
        $query = "DELETE FROM favorites
                  WHERE favorite_id = ?
                  AND user_id = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $favorite_id,
            $user_id
        );

        return mysqli_stmt_execute($stmt);
    }
}

?>

