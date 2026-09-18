<?php
/**
 * Controller: view/edit profile, change password, delete account.
 */
class ProfileController extends Controller
{
    private ProviderModel $providers;

    public function __construct()
    {
        parent::__construct();
        $this->providers = new ProviderModel(Database::getConnection());
    }

    public function index()
    {
        $p = $this->providers->getById($this->providerId);

        $msg = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $company = trim($_POST['company_name'] ?? '');
            $address = trim($_POST['address'] ?? '');

            $requiredName = Validator::required($name, 'Full name');

            if ($requiredName !== true) {
                $error = $requiredName;
            } else {

                $this->providers->updateProfile($this->providerId, $name, $phone, $company, $address);

                Auth::setName($name);

                $msg = 'Profile updated successfully.';

                $p = array_merge(
                    $p,
                    [
                        'full_name' => $name,
                        'phone' => $phone,
                        'company_name' => $company,
                        'address' => $address
                    ]
                );
            }
        }

        $this->render('profile/index', compact('p', 'msg', 'error'));
    }

    public function changePassword()
    {
        $msg = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $current = $_POST['current'] ?? '';
            $new = $_POST['new'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            if ($current === '' || $new === '' || $confirm === '') {

                $error = 'All fields are required.';

            } elseif (strlen($new) < 8) {

                $error = 'New password must be at least 8 characters.';

            } elseif ($new !== $confirm) {

                $error = 'New passwords do not match.';

            } else {

                $provider = $this->providers->getPasswordHash($this->providerId);

                if (!$provider) {

                    $error = 'Provider account not found.';

                } elseif (!password_verify($current, $provider['password'])) {

                    $error = 'Current password is incorrect.';

                } else {

                    $hashedPassword = password_hash($new, PASSWORD_DEFAULT);

                    if ($this->providers->updatePassword($this->providerId, $hashedPassword)) {
                        $msg = 'Password changed successfully.';
                    } else {
                        $error = 'Failed to change password. Please try again.';
                    }
                }
            }
        }

        $this->render('profile/change_password', compact('msg', 'error'));
    }

    public function deleteAccount()
    {
        $this->providers->delete($this->providerId);

        Auth::logout();

        $this->redirect('login.php');
    }
}
