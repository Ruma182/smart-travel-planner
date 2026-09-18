<?php
/**
 * Controller: the provider's overview dashboard.
 */
class DashboardController extends Controller
{
    private ListingModel $listings;
    private BookingModel $bookings;
    private FeedbackModel $feedback;

    public function __construct()
    {
        parent::__construct();

        $conn = Database::getConnection();
        $this->listings = new ListingModel($conn);
        $this->bookings = new BookingModel($conn);
        $this->feedback = new FeedbackModel($conn);
    }

    public function index()
    {
        $providerId = $this->providerId;

        $totalListings = $this->listings->count($providerId);
        $available = $this->listings->sumAvailable($providerId);

        $pending = $this->bookings->countByStatus($providerId, 'Pending');
        $confirmed = $this->bookings->countByStatus($providerId, 'Confirmed');
        $rejected = $this->bookings->countByStatus($providerId, 'Rejected');
        $revenue = $this->bookings->sumRevenue($providerId);

        $rating = $this->feedback->avgRating($providerId);
        $feedbackCount = $this->feedback->count($providerId);

        $rows = $this->bookings->getRecent($providerId, 5);

        $this->render('dashboard/index', compact(
            'totalListings',
            'available',
            'pending',
            'confirmed',
            'rejected',
            'revenue',
            'rating',
            'feedbackCount',
            'rows'
        ));
    }
}
