<?php

require '../app/Database.php';
require '../app/controllers/Auth.controller.php';
require '../app/controllers/Expense.controller.php';
require '../app/controllers/Dashboard.controller.php';

$url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];

$controller = 'Auth';
$action = 'login';

if (isset($_GET['url'])) {
    switch ($_GET['url']) {
        case 'dashboard':
            $controller = 'Dashboard';
            $action = 'index';
            break;
        case 'add-expense':
            $controller = 'Expense';
            $action = 'create';
            break;
        case 'manage-expenses':
            $controller = 'Expense';
            $action = 'manageExpenses';
            break;
        case 'settings':
            $controller = 'User';
            $action = 'settings';
            break;
        case 'logout':
            $controller = 'Auth';
            $action = 'logout';
            break;
        case 'register':
            $controller = 'Auth';
            $action = 'register';
            break;
        default:
            $controller = 'Auth';
            $action = 'login';
            break;
    }
}

require_once "../app/controllers/{$controller}.controller.php";
$controller = "{$controller}Controller";
$controllerInstance = new $controller();
$controllerInstance->$action();
