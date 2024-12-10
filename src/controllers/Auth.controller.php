<?php

namespace Cfurl\ControleDeDespesas\Controllers;

use Cfurl\ControleDeDespesas\Models\UserModel;

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
        
            $user = UserModel::findByEmail($email);
            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                header("Location: /dashboard");
                exit;
            } else {
                $_SESSION['error'] = 'Email ou senha incorretos.';
            }
        }
        require '../app/views/login.php';
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new UserModel();
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];
            $user->password = $_POST['password'];

            if ($user->create()) {
                header("Location: /login");
                exit;
            } else {
                $_SESSION['error'] = 'Erro ao criar a conta. Tente novamente.';
            }
        }
        require '../app/views/register.php';
    }

    public function logout() {
        session_destroy();
        $_SESSION = array();
        header("Location: /login");
        exit;
    }
}