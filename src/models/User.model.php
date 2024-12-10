<?php

namespace Cfurl\ControleDeDespesas\Models;

use PDO;

use Cfurl\ControleDeDespesas\Database;

class UserModel {
    private $pdo;

    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public static function getAllUsers() {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->query("SELECT id, name, email, password FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userObjects = [];
        foreach ($users as $user) {
            $userObject = new self();
            $userObject->id = $user['id'];
            $userObject->name = $user['name'];
            $userObject->email = $user['email'];
            $userObject->password = $user['password'];
            $userObjects[] = $userObject;
        }
        return $userObjects;
    }

    public function create() {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute([
            'name' => $this->name,
            'email' => $this->email,
            'password' => password_hash($this->password, PASSWORD_DEFAULT)
        ]);
    }

    public static function findByEmail($email) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $userObject = new self();
            $userObject->id = $user['id'];
            $userObject->name = $user['name'];
            $userObject->email = $user['email'];
            $userObject->password = $user['password'];
            return $userObject;
        }
        return null;
    }

    public static function findById($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $userObject = new self();
            $userObject->id = $user['id'];
            $userObject->name = $user['name'];
            $userObject->email = $user['email'];
            $userObject->password = $user['password'];
            return $userObject;
        }
        return null;
    }

    public function update() {
        $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
        return $stmt->execute([
            $this->name,
            $this->email,
            password_hash($this->password, PASSWORD_DEFAULT),
            $this->id
        ]);
    }

    public function delete() {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}