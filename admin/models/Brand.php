<?php
class Brand {
    private $conn;

    public function __construct() {
        $this->conn = $GLOBALS['conn']; 
    }

    public function all() {
        $stmt = $this->conn->prepare("SELECT * FROM brands");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
