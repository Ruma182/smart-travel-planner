<?php
/**
 * Controller: view customer feedback and reply to it.
 */
class FeedbackController extends Controller
{
    private FeedbackModel $feedback;

    public function __construct()
    {
        parent::__construct();
        $this->feedback = new FeedbackModel(Database::getConnection());
    }

    public function index()
    {
        $rows = $this->feedback->getAll($this->providerId);

        $this->render('feedback/index', compact('rows'));
    }

    public function reply()
    {
        $id = (int) ($_POST['id'] ?? 0);
        $reply = trim($_POST['reply'] ?? '');

        if (Validator::required($reply, 'Reply') === true) {
            $this->feedback->saveReply($id, $this->providerId, $reply);
        }

        $this->redirect('feedback.php');
    }
}
