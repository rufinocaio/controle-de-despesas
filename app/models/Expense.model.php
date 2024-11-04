<?php

require_once '../app/Database.php';

class ExpenseModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($userId, $amount, $type_id, $description, $date) {
        $stmt = $this->db->prepare("INSERT INTO expenses (user_id, amount, expense_type_id, description, date) VALUES (:user_id, :amount, :type_id, :description, :date)");
        return $stmt->execute([
            'user_id' => $userId,
            'amount' => $amount,
            'type_id' => $type_id,
            'description' => $description,
            'date' => $date
        ]);
    }

    public function createSharedExpense($expenseId, $sharedWithUserId, $amountDue) {
        $stmt = $this->db->prepare("INSERT INTO shared_expenses (expense_id, shared_with_user_id, amount_due) VALUES (:expense_id, :shared_with_user_id, :amount_due)");
        return $stmt->execute([
            'expense_id' => $expenseId,
            'shared_with_user_id' => $sharedWithUserId,
            'amount_due' => $amountDue
        ]);
    }

    public function getExpenseTypes() {
        $stmt = $this->db->query("SELECT * FROM expense_types");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllByUserId($userId) {
        $stmt = $this->db->prepare("SELECT expenses.*, expense_types.name AS type_name FROM expenses JOIN expense_types ON expenses.expense_type_id = expense_types.id WHERE expenses.user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($expenseId) {
        $stmt = $this->db->prepare("DELETE FROM expenses WHERE id = :id");
        return $stmt->execute(['id' => $expenseId]);
    }
}