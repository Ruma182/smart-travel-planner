<?php
require_once __DIR__ . '/../models/QuestionResponse.php';
class QuestionResponseController {
    private $model; public function __construct($conn){$this->model=new QuestionResponse($conn);}
    public function index(){requireLogin(); $id=$_SESSION['explorer_id']; if($_SERVER['REQUEST_METHOD']==='POST'){ $this->model->updateResponse((int)$_POST['id'],$id,trim($_POST['response']??'')); redirect(pageUrl('question_response')); } $items=$this->model->all($id); require __DIR__.'/../views/questions/question_response.php';}
}
?>
