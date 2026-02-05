<?php
require_once '../core/Model.php';

class Product extends Model{


    public function all() {
        return $this->db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO products(name, price, description) VALUES(?, ?, ?)");
        return $stmt->execute([$data['name'], $data['price'], $data['description']]);
    }
}


?>