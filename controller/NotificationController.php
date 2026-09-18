<?php
/**
 * Controller: booking notifications list.
 */
class NotificationController extends Controller
{
    private NotificationModel $notifications;

    public function __construct()
    {
        parent::__construct();
        $this->notifications = new NotificationModel(Database::getConnection());
    }

    public function index()
    {
        $this->notifications->markAllRead($this->providerId);

        $rows = $this->notifications->getAll($this->providerId);

        $this->render('notifications/index', compact('rows'));
    }
}
