<?php

namespace Cfurl\ControleDeDespesas\Controllers;

use Cfurl\ControleDeDespesas\Middleware\AuthMiddleware;

class DashboardController {
    public function index() {
        AuthMiddleware::check();
        $view = '../app/views/dashboard.php';
        require '../app/views/layout.php';
    }
}