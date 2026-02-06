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

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['price'], $data['description'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Return filtered and sorted products.
     * Accepts array $opts with keys: name, price, sort, dir
     */
    public function getFiltered(array $opts = []) {
        $allowedSort = ['id','name','price','created_at'];
        $where = [];
        $params = [];

        if (!empty($opts['name'])) {
            $where[] = 'name LIKE ?';
            $params[] = '%' . $opts['name'] . '%';
        }

        // Single price filter: show products with price <= provided value
        if (isset($opts['price']) && $opts['price'] !== '') {
            // allow numeric input only; otherwise ignore
            if (is_numeric($opts['price'])) {
                $where[] = 'price <= ?';
                $params[] = $opts['price'];
            }
        }

        $sql = 'SELECT * FROM products';
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sort = in_array($opts['sort'] ?? '', $allowedSort) ? $opts['sort'] : 'id';
        $dir = strtoupper($opts['dir'] ?? 'ASC') === 'DESC' ? 'DESC' : 'ASC';

        $sql .= " ORDER BY {$sort} {$dir}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>