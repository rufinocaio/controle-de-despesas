<?php

class ExpenseModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function deleteSharedExpenses($expenseId) {
        $stmt = $this->db->prepare("DELETE FROM shared_expenses WHERE expense_id = :expense_id");
        return $stmt->execute(['expense_id' => $expenseId]);
    }

    public function createSharedExpense($expenseId, $sharedWithUserId, $amountDue) {
        $stmt = $this->db->prepare("INSERT INTO      (expense_id, shared_with_user_id, amount_due) VALUES (:expense_id, :shared_with_user_id, :amount_due)");
        return $stmt->execute([
            'expense_id' => $expenseId,
            'shared_with_user_id' => $sharedWithUserId,
            'amount_due' => $amountDue
        ]);
    }

    public function create($userId, $amount, $type_id, $description, $date, $shared_with, $participants) {
        $stmt = $this->db->prepare("INSERT INTO expenses (user_id, amount, expense_type_id, description, date, shared_with, participants) VALUES (:user_id, :amount, :type_id, :description, :date, :shared_with, :participants)");
        $stmt->execute([
            'user_id' => $userId,
            'amount' => $amount,
            'type_id' => $type_id,
            'description' => $description,
            'date' => $date,
            'shared_with' => $shared_with,
            'participants' => $participants
        ]);
        if ($participants > 1) {
            $participants_id = explode(',', $shared_with);
            
            foreach ($participants_id as $participant_id) {
                $this->createSharedExpense($this->db->lastInsertId(), $participants_id, $amount / $participants);
            }
            
        }
        return $this->db->lastInsertId();
    }

    public function getAllByUserId($userId) {
        $stmt = $this->db->prepare("SELECT expenses.*, expense_types.name AS type_name FROM expenses JOIN expense_types ON expenses.expense_type_id = expense_types.id WHERE expenses.user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getExpenseTypes() {
        $stmt = $this->db->query("SELECT * FROM expense_types");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSharedParticipants($expenseId) {
        $stmt = $this->db->prepare("
            SELECT users.name, shared_expense_participants.amount_due 
            FROM shared_expense_participants 
            JOIN users ON shared_expense_participants.user_id = users.id 
            WHERE shared_expense_participants.expense_id = (
                SELECT id FROM shared_expense_participants WHERE expense_id = :expense_id
            )
        ");
        $stmt->execute(['expense_id' => $expenseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT id, name FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $amount, $type_id, $description, $date) {
        $stmt = $this->db->prepare("UPDATE expenses SET amount = :amount, expense_type_id = :type_id, description = :description, date = :date WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'amount' => $amount,
            'type_id' => $type_id,
            'description' => $description,
            'date' => $date
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM expenses WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

}