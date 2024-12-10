<?php

namespace Cfurl\ControleDeDespesas\Models;

use Cfurl\ControleDeDespesas\Database;
use PDO;

class ExpenseModel {
    private $db;

    public $id;
    public $user_id;
    public $amount;
    public $type_id;
    public $description;
    public $date;
    public $participants;
    public $shared_with;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public static function getAllByUserId($userId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM expenses WHERE user_id = ?");
        $stmt->execute([$userId]);
        $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $expenseObjects = [];
        foreach ($expenses as $expense) {
            $expenseObject = new self();
            $expenseObject->id = $expense['id'];
            $expenseObject->user_id = $expense['user_id'];
            $expenseObject->amount = $expense['amount'];
            $expenseObject->type_id = $expense['expense_type_id'];
            $expenseObject->description = $expense['description'];
            $expenseObject->date = $expense['date'];
            $expenseObject->participants = $expense['participants_number'];
            if ($expenseObject->participants > 1) {
                $stmt = $db->prepare("SELECT users.name, shared_expense_participants.amount_due FROM shared_expense_participants JOIN users ON shared_expense_participants.user_id = users.id WHERE expense_id = ?");
                $stmt->execute([$expense['id']]);
                $expenseObject->shared_with = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $expenseObjects[] = $expenseObject;
        }
        return $expenseObjects;
    }

    public function create($sharedWithUserIds = []) {
        $stmt = $this->db->prepare("INSERT INTO expenses (user_id, amount, expense_type_id, description, date, participants_number) VALUES (:user_id, :amount, :type_id, :description, :date, :participants)");
        $stmt->execute([
            'user_id' => $this->user_id,
            'amount' => floatval(number_format($this->amount, 2, '.', ',')),
            'type_id' => $this->type_id,
            'description' => $this->description,
            'date' => $this->date,
            'participants' => $this->participants
        ]);
        
        $expenseId = $this->db->lastInsertId();

        if ($this->participants > 1) {
            $shared_amount = floatval(number_format($this->amount / $this->participants, 2, '.', ','));
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

    public function update() {
        $stmt = $this->db->prepare("UPDATE expenses SET amount = :amount, expense_type_id = :type_id, description = :description, date = :date, participants_number = :participants WHERE id = :id");
        return $stmt->execute([
            'id' => $this->id,
            'amount' => floatval(number_format($this->amount, 2, '.', ',')),
            'type_id' => $this->type_id,
            'description' => $this->description,
            'date' => $this->date,
            'participants' => $this->participants
        ]);
    }

    public static function findById($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM expenses WHERE id = ?");
        $stmt->execute([$id]);
        $expense = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($expense) {
            $expenseObject = new self();
            $expenseObject->id = $expense['id'];
            $expenseObject->user_id = $expense['user_id'];
            $expenseObject->amount = $expense['amount'];
            $expenseObject->type_id = $expense['expense_type_id'];
            $expenseObject->description = $expense['description'];
            $expenseObject->date = $expense['date'];
            $expenseObject->participants = $expense['participants_number'];
            return $expenseObject;
        }
        return null;
    }

    // Pegar todos os usuários ligados a aquela despesa
    public function getSharedWith() {
        $stmt = $this->db->prepare("SELECT users FROM shared_expense_participants JOIN users ON shared_expense_participants.user_id = users.id WHERE expense_id = ?");
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function delete() {
        $stmt = $this->db->prepare("DELETE FROM expenses WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    
}