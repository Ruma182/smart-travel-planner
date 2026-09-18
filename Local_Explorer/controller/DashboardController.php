<?php
class DashboardController {
    private $conn;
    public function __construct($conn) { $this->conn=$conn; }
    public function index() {
        requireLogin();
        $id=$_SESSION['explorer_id'];
        $counts=[];
        foreach (['local_recommendation','travel_tip','destination_info','question_response','explorer_feedback'] as $table) {
            $stmt=$this->conn->prepare("SELECT COUNT(*) AS c FROM $table WHERE explorer_id=?"); $stmt->bind_param("i",$id); $stmt->execute(); $counts[$table]=$stmt->get_result()->fetch_assoc()['c'];
        }
        require __DIR__ . '/../views/dashboard/dashboard.php';
    }
}
?>
