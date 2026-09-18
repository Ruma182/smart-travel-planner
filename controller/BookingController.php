<?php
/**
 * Controller: view and act on customer booking requests.
 */
class BookingController extends Controller
{
    private BookingModel $bookings;
    private ListingModel $listings;
    private NotificationModel $notifications;

    public function __construct()
    {
        parent::__construct();

        $conn = Database::getConnection();
        $this->bookings = new BookingModel($conn);
        $this->listings = new ListingModel($conn);
        $this->notifications = new NotificationModel($conn);
    }

    public function index()
    {
        $rows = $this->bookings->getAll($this->providerId);

        $this->render('bookings/index', compact('rows'));
    }

    public function action()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $action = $_GET['action'] ?? '';

        if (!in_array($action, ['confirm', 'reject'], true)) {
            die('Invalid action.');
        }

        $status = ($action === 'confirm') ? 'Confirmed' : 'Rejected';

        $booking = $this->bookings->getOne($id, $this->providerId);

        if (!$booking) {
            die('Booking not found.');
        }

        $affected = $this->bookings->updateStatus($id, $this->providerId, $status);

        if ($affected) {

            if ($status === 'Confirmed') {
                $this->listings->reduceAvailability($booking['listing_id'], $this->providerId, $booking['guests']);
            }

            $message = 'Booking #' . $id .
                       ' for ' . $booking['name'] .
                       ' has been ' . $status . '.';

            $this->notifications->create($this->providerId, $id, $message);
        }

        $this->redirect('booking_requests.php');
    }
}
