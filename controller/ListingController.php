<?php
/**
 * Controller: manage a provider's listings (packages, hotels, transport).
 */
class ListingController extends Controller
{
    private const ALLOWED_TYPES = ['Travel Package', 'Hotel', 'Transport'];
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];
    private const MAX_IMAGE_BYTES = 5 * 1024 * 1024;

    private ListingModel $listings;

    public function __construct()
    {
        parent::__construct();
        $this->listings = new ListingModel(Database::getConnection());
    }

    public function index()
    {
        $rows = $this->listings->getAllByProvider($this->providerId);

        if ($this->isAjax()) {
            $this->jsonResponse([
                'success' => true,
                'rows' => $rows->fetch_all(MYSQLI_ASSOC),
            ]);
        }

        $msg = $_GET['msg'] ?? '';

        $this->render('listings/index', compact('rows', 'msg'));
    }

    public function add()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $type = $_POST['listing_type'] ?? '';
            $name = trim($_POST['name'] ?? '');
            $destination = trim($_POST['destination'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = $_POST['price'] ?? '';
            $availability = $_POST['availability'] ?? '';

            $error = $this->validateListing($type, $name, $destination, $price, $availability);

            $price = (float) $price;
            $availability = (int) $availability;

            $image = null;

            if (!$error) {
                [$image, $error] = $this->handleUpload();
            }

            if (!$error) {
                $this->listings->create($this->providerId, $type, $name, $destination, $description, $price, $availability, $image);

                if ($this->isAjax()) {
                    $this->jsonResponse([
                        'success' => true,
                        'message' => 'Listing added successfully',
                    ]);
                }

                $this->redirect('listings.php?msg=Listing added successfully');
            }

            if ($error && $this->isAjax()) {
                $this->jsonResponse([
                    'success' => false,
                    'error' => $error,
                ], 422);
            }
        }

        $this->render('listings/add', compact('error'));
    }

    public function edit()
    {
        $id = (int) ($_GET['id'] ?? 0);

        $item = $this->listings->getOne($id, $this->providerId);

        if (!$item) {
            if ($this->isAjax()) {
                $this->jsonResponse([
                    'success' => false,
                    'error' => 'Listing not found.',
                ], 404);
            }

            die('Listing not found.');
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $type = $_POST['listing_type'] ?? '';
            $name = trim($_POST['name'] ?? '');
            $destination = trim($_POST['destination'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = $_POST['price'] ?? '';
            $availability = $_POST['availability'] ?? '';

            $error = $this->validateListing($type, $name, $destination, $price, $availability);

            $price = (float) $price;
            $availability = (int) $availability;

            $image = $item['image'];

            if (!$error) {
                [$uploaded, $error] = $this->handleUpload();

                if ($uploaded !== null) {
                    $image = $uploaded;
                }
            }

            if (!$error) {
                $this->listings->update($id, $this->providerId, $type, $name, $destination, $description, $price, $availability, $image);

                if ($this->isAjax()) {
                    $this->jsonResponse([
                        'success' => true,
                        'message' => 'Listing updated successfully',
                    ]);
                }

                $this->redirect('listings.php?msg=Listing updated successfully');
            }

            if ($error && $this->isAjax()) {
                $this->jsonResponse([
                    'success' => false,
                    'error' => $error,
                ], 422);
            }
        } elseif ($this->isAjax()) {
            // Plain GET via AJAX: hand back the current record as JSON.
            $this->jsonResponse([
                'success' => true,
                'item' => $item,
            ]);
        }

        $this->render('listings/edit', compact('error', 'item'));
    }

    public function delete()
    {
        $id = (int) ($_GET['id'] ?? 0);

        $this->listings->delete($id, $this->providerId);

        if ($this->isAjax()) {
            $this->jsonResponse([
                'success' => true,
                'message' => 'Listing deleted successfully',
            ]);
        }

        $this->redirect('listings.php?msg=Listing deleted successfully');
    }

    private function validateListing($type, $name, $destination, $price, $availability): string
    {
        $checks = [
            Validator::inList($type, self::ALLOWED_TYPES, 'Listing type'),
            Validator::required($name, 'Name'),
            Validator::required($destination, 'Destination'),
            Validator::numberMin($price, 0, 'Price'),
            Validator::numberMin($availability, 0, 'Availability'),
        ];

        foreach ($checks as $check) {
            if ($check !== true) {
                return $check;
            }
        }

        return '';
    }

    /**
     * @return array{0: ?string, 1: string} [uploaded filename or null, error message]
     */
    private function handleUpload(): array
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return [null, ''];
        }

        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, self::ALLOWED_EXTENSIONS, true)) {
            return [null, 'Only JPG, JPEG, PNG or WEBP images are allowed.'];
        }

        if ($_FILES['image']['size'] > self::MAX_IMAGE_BYTES) {
            return [null, 'Image must be smaller than 5MB.'];
        }

        $image = uniqid('listing_', true) . '.' . $ext;

        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image);

        return [$image, ''];
    }
}
