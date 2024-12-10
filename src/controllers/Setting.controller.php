<?php

namespace Cfurl\ControleDeDespesas\Controllers;

use Cfurl\ControleDeDespesas\Models\UserModel;
use Cfurl\ControleDeDespesas\Middleware\AuthMiddleware;

class SettingController {
    public function settings() {
        AuthMiddleware::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userModel = UserModel::findById($_SESSION['user_id']);
            $userModel->name = $name;
            $userModel->email = $email;
            $userModel->password = $password;
            $userModel->update();
            header("Location: /perfil");
            exit;
        }

        $user = UserModel::findById($_SESSION['user_id']);
        $view = '../app/views/settings.php';
        require '../app/views/layout.php';
    }
}