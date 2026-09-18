<?php
class TravelTip {
    private $conn;
    public function __construct($conn) { $this->conn=$conn; }
    public function all($explorerId) { $stmt=$this->conn->prepare("SELECT * FROM travel_tip WHERE explorer_id=? ORDER BY tip_id DESC"); $stmt->bind_param("i",$explorerId); $stmt->execute(); return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); }
    public function create($explorerId,$title,$content) { $stmt=$this->conn->prepare("INSERT INTO travel_tip (explorer_id,title,content) VALUES (?,?,?)"); $stmt->bind_param("iss",$explorerId,$title,$content); return $stmt->execute(); }
    public function update($id,$explorerId,$title,$content) { $stmt=$this->conn->prepare("UPDATE travel_tip SET title=?,content=? WHERE tip_id=? AND explorer_id=?"); $stmt->bind_param("ssii",$title,$content,$id,$explorerId); return $stmt->execute(); }
    public function delete($id,$explorerId) { $stmt=$this->conn->prepare("DELETE FROM travel_tip WHERE tip_id=? AND explorer_id=?"); $stmt->bind_param("ii",$id,$explorerId); return $stmt->execute(); }
}
?>
