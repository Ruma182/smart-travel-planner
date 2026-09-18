<?php
require_once __DIR__ . '/../models/Recommendation.php';
class RecommendationController {
    private $model; public function __construct($conn){$this->model=new Recommendation($conn);}
    public function index(){requireLogin(); $id=$_SESSION['explorer_id']; if($_SERVER['REQUEST_METHOD']==='POST'){ $action=$_POST['action']??'create'; if($action==='delete') $this->model->delete((int)$_POST['id'],$id); elseif($action==='update') $this->model->update((int)$_POST['id'],$id,trim($_POST['title']),trim($_POST['description']),trim($_POST['category']),trim($_POST['location'])); else $this->model->create($id,trim($_POST['title']),trim($_POST['description']),trim($_POST['category']),trim($_POST['location'])); redirect(pageUrl('recommendation')); } $items=$this->model->all($id); require __DIR__.'/../views/recommendations/recommendation.php';}
}
?>
