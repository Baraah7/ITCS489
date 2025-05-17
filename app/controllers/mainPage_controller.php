<?php
class UserController extends BaseController {
    private $userModel;

    public function __construct() {
        parent::__construct();
        require_once '../app/models/user_model.php';
        $this->userModel = new UserModel();
    }

    public function getCurrentUser() {
        // Check if user is logged in through session
        if (isset($_SESSION['user_id'])) {
            return $this->userModel->getUserById($_SESSION['user_id']);
        }
        return null;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Method to be called by mainPage to get user data
    public function getWelcomeData() {
        $response = ['isLoggedIn' => false, 'userName' => ''];
        
        if ($this->isLoggedIn()) {
            $user = $this->getCurrentUser();
            if ($user) {
                $response = [
                    'isLoggedIn' => true,
                    'userName' => $user['name']
                ];
            }
        }
        
        return json_encode($response);
    }
}
?>
