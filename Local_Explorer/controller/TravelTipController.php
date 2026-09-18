<?php
require_once __DIR__ . '/../models/TravelTip.php';
class TravelTipController {
    private $model; public function __construct($conn){$this->model=new TravelTip($conn);}
    public function index(){requireLogin(); $id=$_SESSION['explorer_id']; if($_SERVER['REQUEST_METHOD']==='POST'){ $action=$_POST['action']??'create'; if($action==='delete') $this->model->delete((int)$_POST['id'],$id); elseif($action==='update') $this->model->update((int)$_POST['id'],$id,trim($_POST['title']),trim($_POST['content'])); else $this->model->create($id,trim($_POST['title']),trim($_POST['content'])); redirect(pageUrl('travel_tip')); } $items=$this->model->all($id); require __DIR__.'/../views/travel_tips/travel_tip.php';}
}
?>
