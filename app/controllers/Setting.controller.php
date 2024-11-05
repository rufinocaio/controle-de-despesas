<?php
class SettingController {
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
        startSession();
        $user = $userModel->findById($_SESSION['user_id']);

        $view = '../app/views/settings.php';
        require '../app/views/layout.php';
    }
}
