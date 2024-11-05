<?php

require '../app/Database.php';
require '../app/controllers/Auth.controller.php';
require '../app/controllers/Expense.controller.php';
require '../app/controllers/Dashboard.controller.php';
require '../app/Session.php';

$_USER = null;

if (isset($_GET['url'])) {
    switch ($_GET['url']) {
        case 'dashboard':
            $controller = 'Dashboard';
            $action = 'index';
            break;
        case 'adicionar-despesa':
            $controller = 'Expense';
            $action = 'create';
            break;
        case 'editar-despesas':
            $controller = 'Expense';
            $action = 'manageExpenses';
            break;
        case 'perfil':
            $controller = 'Setting';
            $action = 'settings';
            break;
        case 'logout':
            $controller = 'Auth';
            $action = 'logout';
            break;
        case 'registrar':
            $controller = 'Auth';
            $action = 'register';
            break;
        case 'login':
            $controller = 'Auth';
            $action = 'login';
            break;
        default:
            $controller = 'Dashboard';
            $action = 'index';
            break;
    }
} else {
    $controller = 'Auth';
    $action = 'login';
}

require_once "../app/controllers/{$controller}.controller.php";
$controller = "{$controller}Controller";
$controllerInstance = new $controller();
$controllerInstance->$action();
