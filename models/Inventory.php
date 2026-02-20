<?php
require_once '../core/Model.php';

class Inventory extends Model {

    public function all() {
        return $this->db
            ->query("SELECT * FROM inventory")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM inventory WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO inventory (name, price, description, quantity)
             VALUES (?, ?, ?, ?)"
        );

        return $stmt->execute([
            $data['name'],
            $data['price'],
            $data['description'],
            $data['quantity']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare(
            "UPDATE inventory 
             SET name = ?, price = ?, description = ?, quantity = ?
             WHERE id = ?"
        );

        return $stmt->execute([
            $data['name'],
            $data['price'],
            $data['description'],
            $data['quantity'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM inventory WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Return filtered and sorted inventory items.
     */
    public function getFiltered(array $opts = []) {
        $allowedSort = ['id', 'name', 'price', 'quantity', 'created_at'];
        $where = [];
        $params = [];

        if (!empty($opts['name'])) {
            $where[] = 'name LIKE ?';
            $params[] = '%' . $opts['name'] . '%';
        }

        if (isset($opts['price']) && $opts['price'] !== '' && is_numeric($opts['price'])) {
            $where[] = 'price <= ?';
            $params[] = $opts['price'];
        }

        if (isset($opts['quantity']) && $opts['quantity'] !== '' && is_numeric($opts['quantity'])) {
            $where[] = 'quantity <= ?';
            $params[] = $opts['quantity'];
        }

        $sql = 'SELECT * FROM inventory';

        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sort = in_array($opts['sort'] ?? '', $allowedSort) ? $opts['sort'] : 'id';
        $dir  = strtoupper($opts['dir'] ?? 'ASC') === 'DESC' ? 'DESC' : 'ASC';

        $sql .= " ORDER BY {$sort} {$dir}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
    