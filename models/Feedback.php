<?php
class Feedback {
    private $conn;
    public function __construct($conn) { $this->conn=$conn; }
    public function all($explorerId) { $stmt=$this->conn->prepare("SELECT * FROM explorer_feedback WHERE explorer_id=? ORDER BY feedback_id DESC"); $stmt->bind_param("i",$explorerId); $stmt->execute(); return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); }
    public function average($explorerId) { $stmt=$this->conn->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total FROM explorer_feedback WHERE explorer_id=?"); $stmt->bind_param("i",$explorerId); $stmt->execute(); return $stmt->get_result()->fetch_assoc(); }
}
?>
