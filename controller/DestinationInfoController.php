<?php
require_once __DIR__ . '/../models/DestinationInfo.php';
class DestinationInfoController {
    private $model; public function __construct($conn){$this->model=new DestinationInfo($conn);}
    public function index(){requireLogin(); $id=$_SESSION['explorer_id']; if($_SERVER['REQUEST_METHOD']==='POST'){ $action=$_POST['action']??'create'; $photo=trim($_POST['photos']??''); if(isset($_FILES['photo']) && $_FILES['photo']['error']!==UPLOAD_ERR_NO_FILE){$uploaded=uploadImage($_FILES['photo']); if($uploaded)$photo=$uploaded;} $data=[(int)($_POST['destination_id']??0),trim($_POST['description']??''),$photo,trim($_POST['visiting_guidelines']??''),trim($_POST['recommended_activities']??'')]; if($action==='delete') $this->model->delete((int)$_POST['id'],$id); elseif($action==='update') $this->model->update((int)$_POST['id'],$id,...$data); else $this->model->create($id,...$data); redirect(pageUrl('destination_info')); } $items=$this->model->all($id); require __DIR__.'/../views/destinations/destination_info.php';}
}
?>
