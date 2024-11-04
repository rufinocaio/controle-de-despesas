<?php

require_once '../app/models/Expense.model.php';
require_once '../app/middleware/AuthMiddleware.php';
require_once '../app/session.php';
class ExpenseController {
    public function index() {
        AuthMiddleware::check(); // Verifica se o usuário está logado

        $expenseModel = new ExpenseModel();
        $expenses = $expenseModel->getAllByUserId($_SESSION['user_id']);
        $view = '../app/views/expenses.php';
        require '../app/views/layout.php';
    }

    public function create() {
        $expenseModel = new ExpenseModel();

        // Carrega os tipos de despesa para o formulário
        $expenseTypes = $expenseModel->getExpenseTypes();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = $_POST['amount'];
            $type_id = $_POST['type_id'];
            $description = $_POST['description'];
            $date = $_POST['date'];
            $sharedWithUserIds = $_POST['shared_with'] ?? []; // IDs de outros usuários
            $userId = $_SESSION['user_id'];

            // Cria a despesa e obtém o ID
            $expenseId = $expenseModel->create($userId, $amount, $type_id, $description, $date);

            // Registra despesas compartilhadas, se houver
            foreach ($sharedWithUserIds as $sharedWithUserId) {
                $sharedAmount = $amount / (count($sharedWithUserIds) + 1); // Divide igualmente
                $expenseModel->createSharedExpense($expenseId, $sharedWithUserId, $sharedAmount);
            }

            header("Location: /public/index.php?url=manage-expenses");
            exit;
        }

        $view = '../app/views/Create_Expense.php';
        require '../app/views/layout.php';
    }

    public function manageExpenses() {
        $expenseModel = new ExpenseModel();
        $expenses = $expenseModel->getAllByUserId($_SESSION['user_id']);

        $view = '../app/views/Manage_Expense.php';
        require '../app/views/layout.php';
    }


    public function delete($id) {
        AuthMiddleware::check(); // Verifica se o usuário está logado

        $expenseModel = new ExpenseModel();
        $expenseModel->delete($id);
        header("Location: /public/index.php?url=expenses");
        exit;
    }
}
