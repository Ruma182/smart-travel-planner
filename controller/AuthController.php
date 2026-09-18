<?php
/**
 * Controller: sign in, sign up, sign out.
 */
class AuthController extends Controller
{
    private ProviderModel $providers;

    public function __construct()
    {
        parent::__construct(false);
        $this->providers = new ProviderModel(Database::getConnection());
    }

    public function login()
    {
        if (Auth::check()) {
            $this->redirect('dashboard.php');
        }

        $error = '';
        $msg = $_GET['msg'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $requiredEmail = Validator::required($email, 'Email');
            $requiredPassword = Validator::required($password, 'Password');
            $validEmail = $email === '' ? true : Validator::email($email);

            if ($requiredEmail !== true) {
                $error = $requiredEmail;
            } elseif ($validEmail !== true) {
                $error = $validEmail;
            } elseif ($requiredPassword !== true) {
                $error = $requiredPassword;
            } else {

                $row = $this->providers->findByEmail($email);

                if (
                    $row &&
                    password_verify($password, $row['password']) &&
                    $row['status'] === 'active'
                ) {
                    Auth::login($row['provider_id'], $row['full_name']);
                    $this->redirect('dashboard.php');
                }

                $error = ($row && $row['status'] !== 'active')
                    ? 'Your account is not active. Please contact support.'
                    : 'Invalid email or password.';
            }
        }

        $this->render('auth/login', compact('error', 'msg'));
    }

    public function register()
    {
        if (Auth::check()) {
            $this->redirect('dashboard.php');
        }

        $error = '';
        $old = [
            'full_name'    => '',
            'email'        => '',
            'phone'        => '',
            'company_name' => '',
            'address'      => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $full_name    = trim($_POST['full_name'] ?? '');
            $email        = trim($_POST['email'] ?? '');
            $phone        = trim($_POST['phone'] ?? '');
            $company_name = trim($_POST['company_name'] ?? '');
            $address      = trim($_POST['address'] ?? '');
            $password     = $_POST['password'] ?? '';
            $confirm      = $_POST['confirm'] ?? '';

            $old = compact('full_name', 'email', 'phone', 'company_name', 'address');

            if ($full_name === '' || $email === '' || $password === '') {
                $error = 'Full name, email and password are required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } elseif (strlen($password) < 8) {
                $error = 'Password must be at least 8 characters.';
            } elseif ($password !== $confirm) {
                $error = 'Passwords do not match.';
            } elseif ($this->providers->emailExists($email)) {
                $error = 'An account with this email already exists.';
            } else {

                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $newId = $this->providers->create($full_name, $email, $hashed, $phone, $company_name, $address);

                if ($newId) {
                    Auth::login($newId, $full_name);
                    $this->redirect('dashboard.php');
                }

                $error = 'Something went wrong while creating your account. Please try again.';
            }
        }

        $this->render('auth/register', compact('error', 'old'));
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect('login.php');
    }
}
