<?php
require_once 'db.php';

class Commission {

    public static function distribute($saleId, $buyerId, $amount)
    {
        global $pdo;

        $levels = [0.10, .05, .03, .02, .01];

        $uid = $buyerId;

        for ($i = 0; $i < 5; $i++) {

            $q = $pdo->prepare("SELECT parent_id FROM users WHERE id = ?");
            $q->execute([$uid]);
            $parent = $q->fetchColumn();

            if (!$parent) {
                break;
            }

            $amt = $amount * $levels[$i];

            $ins = $pdo->prepare(
                "INSERT INTO commissions (sale_id, user_id, level, commission_amt)
                 VALUES (?, ?, ?, ?)"
            );
            $ins->execute([$saleId, $parent, $i + 1, $amt]);

            $uid = $parent;
        }
    }

    public static function getAll()
    {
        global $pdo;

        $sql = "
            SELECT 
                c.*, 
                u.name AS affiliate_name, 
                s.amount AS sale_amount,
                b.name AS buyer_name
            FROM commissions c
            INNER JOIN users u ON u.id = c.user_id
            INNER JOIN sales s ON s.id = c.sale_id
            INNER JOIN users b ON b.id = s.user_id
            ORDER BY c.id DESC
        ";

        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getPaginated($limit, $offset) {
        global $pdo;

        $sql = "
            SELECT 
                c.*, 
                u.name AS affiliate_name, 
                s.amount AS sale_amount,
                b.name AS buyer_name
            FROM commissions c
            INNER JOIN users u ON u.id = c.user_id
            INNER JOIN sales s ON s.id = c.sale_id
            INNER JOIN users b ON b.id = s.user_id
            ORDER BY c.id DESC
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
        return $pdo->query("SELECT COUNT(*) FROM commissions")->fetchColumn();
    }


}
