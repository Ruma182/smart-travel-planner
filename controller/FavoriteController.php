
<?php

class FavoriteController
{
    private $favorite;

    public function __construct($conn)
    {
        require_once __DIR__ . '/../models/Favorite.php';

        $this->favorite = new Favorite($conn);
    }

    private function checkTraveler()
    {
        if (!isset($_SESSION["user_id"])) {
            header("Location: login.php");
            exit();
        }

        if ($_SESSION["role"] != "traveler") {
            header("Location: login.php");
            exit();
        }
    }

    public function index()
    {
        $this->checkTraveler();

        $user_id = $_SESSION["user_id"];

        $result = $this->favorite->getByUser($user_id);

        require __DIR__ . '/../views/favorites/index.php';
    }

    public function add()
    {
        $this->checkTraveler();

        if (!isset($_GET["destination"])) {
            header("Location: destinations.php");
            exit();
        }

        $user_id = $_SESSION["user_id"];

        $destination_name = trim($_GET["destination"]);

        $this->favorite->add(
            $user_id,
            $destination_name
        );

        header(
            "Location: /web-technology/smart-travel-planner/favorite_mvc.php"
        );

        exit();
    }

    public function delete()
    {
        $this->checkTraveler();

        if (!isset($_GET["favorite_id"])) {
            header(
                "Location: /web-technology/smart-travel-planner/favorite_mvc.php"
            );

            exit();
        }

        $user_id = $_SESSION["user_id"];

        $favorite_id = intval($_GET["favorite_id"]);

        $this->favorite->delete(
            $favorite_id,
            $user_id
        );

        header(
            "Location: /web-technology/smart-travel-planner/favorite_mvc.php"
        );

        exit();
    }
}

?>

