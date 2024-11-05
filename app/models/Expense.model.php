<?php

class ExpenseModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($userId, $amount, $type_id, $description, $date, $sharedWithUserIds, $participants) {
        $stmt = $this->db->prepare("INSERT INTO expenses (user_id, amount, expense_type_id, description, date, participants_number) VALUES (:user_id, :amount, :type_id, :description, :date, :participants)");
        $stmt->execute([
            'user_id' => $userId,
            'amount' => floatval(number_format($amount, 2, '.', ',')),
            'type_id' => $type_id,
            'description' => $description,
            'date' => $date,
            'participants' => $participants
        ]);
        $expenseId = $this->db->lastInsertId();

        if ($participants > 1) {
            $shared_amount = floatval(number_format($amount / $participants, 2, '.', ','));
            foreach ($sharedWithUserIds as $sharedWithUserId) {
                $this->createSharedExpense($expenseId, $sharedWithUserId, $shared_amount);
            }
        }

        return $expenseId;
    }

    public function createSharedExpense($expenseId, $sharedWithUserId, $amountDue) {
        $stmt = $this->db->prepare("INSERT INTO shared_expense_participants (expense_id, user_id, amount_due) VALUES (:expense_id, :user_id, :amount_due)");
        return $stmt->execute([
            'expense_id' => $expenseId,
            'user_id' => $sharedWithUserId,
            'amount_due' => $amountDue
        ]);
    }

    public function deleteSharedExpenses($expenseId) {
        $stmt = $this->db->prepare("DELETE FROM shared_expense_participants WHERE expense_id = :expense_id");
        return $stmt->execute(['expense_id' => $expenseId]);
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
            SELECT users.id, users.name, shared_expense_participants.amount_due 
            FROM shared_expense_participants 
            JOIN users ON shared_expense_participants.user_id = users.id 
            WHERE shared_expense_participants.expense_id = :expense_id
        ");
        $stmt->execute(['expense_id' => $expenseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT id, name FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $amount, $type_id, $description, $date, $sharedWithUserIds, $participants) {
        $stmt = $this->db->prepare("UPDATE expenses SET amount = :amount, expense_type_id = :type_id, description = :description, date = :date, participants_number = :participants WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'amount' => floatval(number_format($amount, 2, '.', ',')),
            'type_id' => $type_id,
            'description' => $description,
            'date' => $date,
            'participants' => $participants
        ]);

        if ($participants > 1) {
            $shared_amount = floatval(number_format($amount / $participants, 2, '.', ','));
            foreach ($sharedWithUserIds as $sharedWithUserId) {
                $this->createSharedExpense($id, $sharedWithUserId, $shared_amount);
            }
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM expenses WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}