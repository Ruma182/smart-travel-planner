<?php
class Recommendation {
    private $conn;
    public function __construct($conn) { $this->conn = $conn; }
    public function all($explorerId) {
        $stmt=$this->conn->prepare("SELECT * FROM local_recommendation WHERE explorer_id=? ORDER BY recommendation_id DESC");
        $stmt->bind_param("i",$explorerId); $stmt->execute(); return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function create($explorerId,$title,$description,$category,$location) {
        $stmt=$this->conn->prepare("INSERT INTO local_recommendation (explorer_id,title,description,category,location) VALUES (?,?,?,?,?)");
        $stmt->bind_param("issss",$explorerId,$title,$description,$category,$location); return $stmt->execute();
    }
    public function update($id,$explorerId,$title,$description,$category,$location) {
        $stmt=$this->conn->prepare("UPDATE local_recommendation SET title=?,description=?,category=?,location=? WHERE recommendation_id=? AND explorer_id=?");
        $stmt->bind_param("ssssii",$title,$description,$category,$location,$id,$explorerId); return $stmt->execute();
    }
    public function delete($id,$explorerId) {
        $stmt=$this->conn->prepare("DELETE FROM local_recommendation WHERE recommendation_id=? AND explorer_id=?");
        $stmt->bind_param("ii",$id,$explorerId); return $stmt->execute();
    }
}
?>
