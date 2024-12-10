<?php

namespace Cfurl\ControleDeDespesas\Controllers;

use Cfurl\ControleDeDespesas\Models\ExpenseModel;
use Cfurl\ControleDeDespesas\Middleware\AuthMiddleware;
use Cfurl\ControleDeDespesas\Models\ExpenseTypeModel;
use Cfurl\ControleDeDespesas\Models\UserModel;

class ExpenseController {
    public function index() {
        AuthMiddleware::check();
        $expenses = ExpenseModel::getAllByUserId($_SESSION['user_id']);
        $view = '../app/views/expenses.php';
        require '../app/views/layout.php';
    }

    public function create() {
        AuthMiddleware::check();
        $expense = new ExpenseModel();

        // Fetch expense types from the model
        $expenseTypes = ExpenseTypeModel::getAll();

        // Fetch all users for the shared_with field
        $users = UserModel::getAllUsers();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            print($_SESSION['user_id']);
            $expense->user_id = $_SESSION['user_id'];
            $expense->amount = $_POST['amount'];    
            $expense->type_id = $_POST['type_id'];
            $expense->description = $_POST['description'];
            $expense->date = $_POST['date'];
            $sharedWithUserIds = $_POST['shared_with'] ?? [];
            $expense->participants = count($sharedWithUserIds) + 1;

            $expense->create($sharedWithUserIds);
            header("Location: /editar-despesas");
            exit;
        }
        $view = '../app/views/Create_Expense.php';
        require '../app/views/layout.php';
    }

    public function manageExpenses() {
        AuthMiddleware::check();
        $expenses = ExpenseModel::getAllByUserId($_SESSION['user_id']);
        $view = '../app/views/Manage_Expense.php';
        require '../app/views/layout.php';
    }

    public function edit() {
        AuthMiddleware::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $expense = ExpenseModel::findById($_POST['EditId']);
            $expense->amount = $_POST['editAmount'];
            $expense->type_id = $_POST['editType_id'];
            $expense->description = $_POST['editDescription'];
            $expense->date = $_POST['editDate'];
            $sharedWithUserIds = $_POST['editShared_with'] ?? [];
            $expense->participants = count($sharedWithUserIds) + 1;

            $expense->update();
            header("Location: /editar-despesas");
            exit;
        }
    }

    public function deleteExpense() {
        AuthMiddleware::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $expense = ExpenseModel::findById($_POST['id']);
            $expense->delete();
            header("Location: /editar-despesas");
            exit;
        }
    }
}