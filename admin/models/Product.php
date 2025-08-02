<?php
require_once "env.php";

class Product {
    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    public function all() {
        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO products(name, brand_id, category_id, description, price, created_at, updated_at) 
                                    VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
        return $stmt->execute([
            $data['name'], $data['brand_id'], $data['category_id'], $data['description'], $data['price']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE products SET name=?, brand_id=?, category_id=?, description=?, price=?, updated_at=NOW() WHERE id=?");
        return $stmt->execute([
            $data['name'], $data['brand_id'], $data['category_id'], $data['description'], $data['price'], $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
