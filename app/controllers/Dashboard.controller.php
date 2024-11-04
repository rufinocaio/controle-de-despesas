<?php

require_once '../app/models/Expense.model.php';

class DashboardController {

    public function index() {
        $view = '../app/views/dashboard.php';
        require '../app/views/layout.php';
    }
    
}
