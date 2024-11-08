<?php
require_once '../app/models/Expense.model.php';
require_once '../app/middleware/AuthMiddleware.php';

class ExpenseController {
    public function index() {
        AuthMiddleware::check(); // Verifica se o usuário está logado
        $expenseModel = new ExpenseModel();
        $expenses = $expenseModel->getAllByUserId($_SESSION['user_id']);
        $view = '../app/views/expenses.php';
        require '../app/views/layout.php';
    }

    public function create() {
        AuthMiddleware::check(); 
        $expenseModel = new ExpenseModel();
        $userModel = new UserModel();
        // Carrega os tipos de despesa para o formulário
        $expenseTypes = $expenseModel->getExpenseTypes();
        $users = $userModel->getAllUsers(); // Adicione este método ao modelo para obter todos os usuários
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = $_POST['amount'];
            $type_id = $_POST['type_id'];
            $description = $_POST['description'];
            $date = $_POST['date'];
            $sharedWithUserIds = $_POST['shared_with'] ?? []; // IDs de outros usuários
            $userId = $_SESSION['user_id'];
            $participants = count($sharedWithUserIds) + 1; // Conta o usuário atual
            // Cria a despesa e obtém o ID
            $expenseId = $expenseModel->create($userId, $amount, $type_id, $description, $date, $sharedWithUserIds, $participants);
            header("Location: /public/index.php?url=editar-despesas");
            exit;
        }
        $view = '../app/views/Create_Expense.php';
        require '../app/views/layout.php';
    }

    public function manageExpenses() {
        AuthMiddleware::check(); // Verifica se o usuário está logado
        $expenseModel = new ExpenseModel();
        $userModel = new UserModel();
        $expenses = $expenseModel->getAllByUserId($_SESSION['user_id']);
        foreach ($expenses as $expense) {
            $expense['shared_with'] = $expenseModel->getSharedParticipants($expense['id']);
            $updatedExpenses[] = $expense;
        }
        $expenseTypes = $expenseModel->getExpenseTypes();
        $users = $userModel->getAllUsers(); // Adicione este método ao modelo para obter todos os usuários
        $view = '../app/views/Manage_Expense.php';
        require '../app/views/layout.php';
    }

    public function edit() {
        AuthMiddleware::check(); // Verifica se o usuário está logado
        $expenseModel = new ExpenseModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['EditId'];
            $amount = $_POST['editAmount'];
            $type_id = $_POST['editType_id'];
            $description = $_POST['editDescription'];
            $date = $_POST['editDate'];
            $sharedWithUserIds = $_POST['editShared_with'] ?? [];
            $participants = count($sharedWithUserIds) + 1; // Conta o usuário atual
            $expenseModel->deleteSharedExpenses($id);
            $expenseModel->update($id, $amount, $type_id, $description, $date, $sharedWithUserIds, $participants);
            header("Location: /public/index.php?url=editar-despesas");
            exit;
        }
    }

    public function deleteExpense() {
        AuthMiddleware::check(); // Verifica se o usuário está logado
        $expenseModel = new ExpenseModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $expenseModel->delete($id);
            header("Location: /public/index.php?url=editar-despesas");
            exit;
        }
    }
}