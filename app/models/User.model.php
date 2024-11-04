<?php

require_once '../app/Database.php';

class UserModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function create($name, $email, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $password]);
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $email, $password) {
        $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
        return $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function settings() {
        $view = '../app/views/settings.php';
        require '../app/views/layout.php';
    }
}