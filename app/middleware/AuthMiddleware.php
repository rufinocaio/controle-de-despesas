<?php
class AuthMiddleware {
    public static function check() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /public/index.php?url=login"); // Redireciona para o login se não estiver autenticado
            exit;
        }
    }
}
