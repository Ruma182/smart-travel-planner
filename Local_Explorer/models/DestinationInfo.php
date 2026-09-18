<?php
class DestinationInfo {
    private $conn;
    public function __construct($conn) { $this->conn=$conn; }
    public function all($explorerId) { $stmt=$this->conn->prepare("SELECT * FROM destination_info WHERE explorer_id=? ORDER BY info_id DESC"); $stmt->bind_param("i",$explorerId); $stmt->execute(); return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); }
    public function create($explorerId,$destinationId,$description,$photos,$guidelines,$activities) { $stmt=$this->conn->prepare("INSERT INTO destination_info (explorer_id,destination_id,description,photos,visiting_guidelines,recommended_activities) VALUES (?,?,?,?,?,?)"); $stmt->bind_param("iissss",$explorerId,$destinationId,$description,$photos,$guidelines,$activities); return $stmt->execute(); }
    public function update($id,$explorerId,$destinationId,$description,$photos,$guidelines,$activities) { $stmt=$this->conn->prepare("UPDATE destination_info SET destination_id=?,description=?,photos=?,visiting_guidelines=?,recommended_activities=? WHERE info_id=? AND explorer_id=?"); $stmt->bind_param("issssii",$destinationId,$description,$photos,$guidelines,$activities,$id,$explorerId); return $stmt->execute(); }
    public function delete($id,$explorerId) { $stmt=$this->conn->prepare("DELETE FROM destination_info WHERE info_id=? AND explorer_id=?"); $stmt->bind_param("ii",$id,$explorerId); return $stmt->execute(); }
}
?>
