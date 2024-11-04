<?php
class SettingsController {
    public function settings() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userModel = new UserModel();

            $userModel->update($_SESSION['user_id'], $name, $email, $password);
            header("Location: /public/index.php?url=settings");
            exit;
        }

        $userModel = new UserModel();
        $user = $userModel->findByEmail($_SESSION['user_id']);

        $view = '../views/settings.php';
        require '../views/layout.php';
    }
}
