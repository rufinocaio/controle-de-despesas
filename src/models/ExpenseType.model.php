<?php

namespace Cfurl\ControleDeDespesas\Models;

use Cfurl\ControleDeDespesas\Database;

use PDO;
class ExpenseTypeModel {
    private $db;

    private $id;
    private $name;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM expense_types");
        $expenseTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $expenseTypeObjects = [];
        foreach ($expenseTypes as $expenseType) {
            $expenseTypeObject = new self();
            $expenseTypeObject->id = $expenseType['id'];
            $expenseTypeObject->name = $expenseType['name'];
            $expenseTypeObjects[] = $expenseTypeObject;
        }
        return $expenseTypeObjects;
    }

    public static function findById($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM expense_types WHERE id = ?");
        $stmt->execute([$id]);
        $expenseType = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($expenseType) {
            $expenseTypeObject = new self();
            $expenseTypeObject->id = $expenseType['id'];
            $expenseTypeObject->name = $expenseType['name'];
            return $expenseTypeObject;
        }
        return null;
    }

    public function create() {
        $stmt = $this->db->prepare("INSERT INTO expense_types (name) VALUES (:name)");
        return $stmt->execute([
            'name' => $this->name
        ]);
    }

    public function update() {
        $stmt = $this->db->prepare("UPDATE expense_types SET name = :name WHERE id = :id");
        return $stmt->execute([
            'id' => $this->id,
            'name' => $this->name
        ]);
    }

    public function delete() {
        $stmt = $this->db->prepare("DELETE FROM expense_types WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    // Setters and Getters 

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
}