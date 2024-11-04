<?php

require_once '../app/models/User.model.php';


class AuthController {
    public function login() {
        
        // Redireciona para o dashboard se o usuário já estiver logado
        if (isset($_SESSION['user_id'])) {
            header("Location: /public/index.php?url=dashboard");
            exit;
        }

        // Processa o formulário de login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                echo $_SESSION['user_id'];
                header("Location: /public/index.php?url=dashboard");
                exit;
            } else {
                $_SESSION['error'] = 'Email ou senha incorretos.';
            }
        }
        /*
        $view = '../app/views/login.php';
        require '../app/views/layout.php';*/
        require '../app/views/login.php';
    }

    public function register() {

        // Redireciona para o dashboard se o usuário já estiver logado
        if (isset($_SESSION['user_id'])) {
            header("Location: /public/index.php?url=dashboard");
            exit;
        }

        // Processa o formulário de registro
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Verifica se a senha e a confirmação de senha coincidem
            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'As senhas não coincidem.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                $userModel = new UserModel();
                if ($userModel->create($name, $email, $hashedPassword)) {
                    header("Location: /public/index.php?url=login");
                    exit;
                } else {
                    $_SESSION['error'] = 'Erro ao criar a conta. Tente novamente.';
                }
            }
        }

        $view = '../app/views/register.php';
        require '../app/views/layout.php';
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_unset(); // Remove todas as variáveis de sessão
        session_destroy(); // Destroi a sessão
        header("Location: /public/index.php?url=login");
        exit;
    }
}
