<?php
class QuestionResponse {
    private $conn;
    public function __construct($conn) { $this->conn=$conn; }
    public function all($explorerId) { $stmt=$this->conn->prepare("SELECT * FROM question_response WHERE explorer_id=? ORDER BY response_id DESC"); $stmt->bind_param("i",$explorerId); $stmt->execute(); return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); }
    public function updateResponse($id,$explorerId,$response) { $stmt=$this->conn->prepare("UPDATE question_response SET response=? WHERE response_id=? AND explorer_id=?"); $stmt->bind_param("sii",$response,$id,$explorerId); return $stmt->execute(); }
}
?>
