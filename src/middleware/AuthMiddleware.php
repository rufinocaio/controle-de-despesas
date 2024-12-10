<?php

namespace Cfurl\ControleDeDespesas\Middleware;

class AuthMiddleware {
    public static function check() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login"); // Redireciona para o login se não estiver autenticado
        }
    }
}
