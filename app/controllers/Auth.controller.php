<?php

require_once '../app/models/User.model.php';

class AuthController {
    public function login() {
        startSession();
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
                //require_once '../app/session.php';
                //setcookie('user_id', $user['id'],time() - 3600);
                $_SESSION['user_id'] = $user['id'];
                
                header("Location: /public/index.php?url=dashboard");
                exit;
            } else {
                $_SESSION['error'] = 'Email ou senha incorretos.';
            }
        }
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

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $userModel = new UserModel();
            if ($userModel->create($name, $email, $hashedPassword)) {
                header("Location: /public/index.php?url=login");
                exit;
            } else {
                $_SESSION['error'] = 'Erro ao criar a conta. Tente novamente.';
            }
        }
        require '../app/views/register.php';
    }

    public function logout() {
        //require_once '../app/session.php';
        startSession();
        // Destroi a sessão
        session_destroy();
        $_SESSION = [];

        if(isset($_COOKIE[session_name()])):
            setcookie(session_name(),'',time()-7000000,'/');
        endif;

        header("Location: /public/index.php?url=login");
        exit;
    }
}