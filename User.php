<?php
require_once 'db.php';

class User {

    public static function add($name, $parentId = null)
    {
        global $pdo;

        $st = $pdo->prepare("INSERT INTO users (name, parent_id) VALUES (?, ?)");
        $st->execute([$name, $parentId]);

        return $pdo->lastInsertId();
    }

    public static function getAll()
    {
        global $pdo;

        $q = $pdo->query("SELECT id, name, parent_id FROM users ORDER BY name ASC");
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getName($id)
    {
        global $pdo;

        $s = $pdo->prepare("SELECT name FROM users WHERE id = ?");
        $s->execute([$id]);

        return $s->fetchColumn();
    }

    public static function getPaginated($limit, $offset) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT id, name, parent_id FROM users ORDER BY id DESC LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countAll() {
        global $pdo;
        return $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

}
