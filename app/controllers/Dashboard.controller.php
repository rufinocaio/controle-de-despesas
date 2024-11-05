<?php

require_once '../app/models/Expense.model.php';

class DashboardController {

    public function index() {
        startSession();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /public/index.php?url=login");
            echo "oi";
            exit;
        }
        $view = '../app/views/dashboard.php';
        require '../app/views/layout.php';
    }
    
}
