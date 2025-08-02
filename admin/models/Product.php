<?php
class Product {
    private $conn;

    public function __construct() {
        $this->conn = $GLOBALS['conn'];
    }

    public function all() {
        $stmt = $this->conn->prepare("
            SELECT p.*, b.name AS brand_name, c.name AS category_name
            FROM products p
            JOIN brands b ON p.brand_id = b.id
            JOIN categories c ON p.category_id = c.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $stmt = $this->conn->prepare("INSERT INTO products(name, brand_id, category_id, description, price, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([
            $data['name'], $data['brand_id'], $data['category_id'], $data['description'], $data['price']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE products SET name=?, brand_id=?, category_id=?, description=?, price=?, updated_at=NOW() WHERE id=?");
        return $stmt->execute([
            $data['name'], $data['brand_id'], $data['category_id'], $data['description'], $data['price'], $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
