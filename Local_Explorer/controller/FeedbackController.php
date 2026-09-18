<?php
require_once __DIR__ . '/../models/Feedback.php';
class FeedbackController {
    private $model; public function __construct($conn){$this->model=new Feedback($conn);}
    public function index(){requireLogin(); $id=$_SESSION['explorer_id']; $items=$this->model->all($id); $summary=$this->model->average($id); require __DIR__.'/../views/feedback/feedback.php';}
}
?>
