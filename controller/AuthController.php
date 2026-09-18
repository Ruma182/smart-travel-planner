<?php
require_once __DIR__ . '/../models/User.php';
class AuthController {
    private $conn;
    public function __construct($conn) { $this->conn=$conn; }
    public function login() {
        $error='';
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $email=trim($_POST['email'] ?? ''); $password=$_POST['password'] ?? '';
            $user=(new User($this->conn))->findByEmail($email);
            if ($user && password_verify($password,$user['password'])) {
                $explorer=(new User($this->conn))->getExplorerByUser($user['id']);
                if ($explorer) { $_SESSION['user_id']=$user['id']; $_SESSION['explorer_id']=$explorer['explorer_id']; $_SESSION['username']=$user['name']; redirect(pageUrl('dashboard')); }
                $error='Local Explorer account was not found.';
            } else $error='Invalid email or password.';
        }
        require __DIR__ . '/../views/auth/login.php';
    }
    public function register() {
        $error='';
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $name=trim($_POST['name'] ?? ''); $email=trim($_POST['email'] ?? ''); $password=$_POST['password'] ?? ''; $location=trim($_POST['location'] ?? ''); $bio=trim($_POST['bio'] ?? '');
            $userModel=new User($this->conn);
            if ($name==='' || $email==='' || $password==='' || $location==='') $error='Please fill in all required fields.';
            elseif ($userModel->emailExists($email)) $error='Email already exists.';
            else { $userId=$userModel->create($name,$email,$password); if($userId && $userModel->createExplorer($userId,$location,$bio)) redirect(pageUrl('login').'&registered=1'); $error='Registration failed.'; }
        }
        require __DIR__ . '/../views/auth/registration.php';
    }
    public function logout() { session_unset(); session_destroy(); redirect(pageUrl('login')); }
}
?>
