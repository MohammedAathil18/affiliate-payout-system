<?php
require_once 'db.php';

class Sale {

    public static function add($affiliateId, $product, $amount)
    {
        global $pdo;

        $stmt = $pdo->prepare("
            INSERT INTO sales (user_id, product, amount, sale_date) 
            VALUES (?, ?, ?, NOW())
        ");
        $stmt->execute([$affiliateId, $product, $amount]);

        return $pdo->lastInsertId();
    }


    public static function getAll()
    {
        global $pdo;

        $sql = "
            SELECT s.*, u.name
            FROM sales s
            INNER JOIN users u ON u.id = s.user_id
            ORDER BY s.id DESC
        ";

        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getPaginated($limit, $offset) {
        global $pdo;

        $sql = "
            SELECT s.*, u.name
            FROM sales s
            INNER JOIN users u ON u.id = s.user_id
            ORDER BY s.id DESC
            LIMIT ? OFFSET ?
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countAll() {
        global $pdo;
        return $pdo->query("SELECT COUNT(*) FROM sales")->fetchColumn();
    }

}
