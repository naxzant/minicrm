<?php

require_once __DIR__ . '/../../models/Inventory.php';

class InventoryController {

    protected $inventory;

    public function __construct() {
        $this->inventory = new Inventory();
    }

    // List inventory items 
    public function index() {
        $opts = [];
        $opts['name'] = isset($_GET['name']) ? trim($_GET['name']) : '';
        $opts['price'] = isset($_GET['price']) ? trim($_GET['price']) : '';
        $opts['quantity'] = isset($_GET['quantity']) ? trim($_GET['quantity']) : '';
        $opts['sort'] = isset($_GET['sort']) ? trim($_GET['sort']) : 'id';
        $opts['dir'] = isset($_GET['dir']) ? trim($_GET['dir']) : 'ASC';

        $items = $this->inventory->getFiltered($opts);
        require __DIR__ . '/../../views/admin/inventory/index.php';
    }

    // Show create form
    public function create() {
        $item = [
            'name' => '',
            'price' => '',
            'description' => '',
            'quantity' => 0
        ];
        $action = 'store';
        require __DIR__ . '/../../views/admin/inventory/form.php';
    }

    // Handle store POST
    public function store() {
        $data = [
            'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
            'price' => isset($_POST['price']) ? trim($_POST['price']) : 0,
            'description' => isset($_POST['description']) ? trim($_POST['description']) : '',
            'quantity' => isset($_POST['quantity']) ? intval($_POST['quantity']) : 0,
        ];

        if ($data['name'] === '') {
            $_SESSION['error'] = 'Name is required';
            header('Location: admin.php?controller=inventory&action=create');
            exit;
        }

        $this->inventory->create($data);
        header('Location: admin.php?controller=inventory');
        exit;
    }

    // Show edit form
    public function edit($id) {
        $item = $this->inventory->find($id);
        if (!$item) {
            header('Location: admin.php?controller=inventory');
            exit;
        }

        $action = 'update';
        require __DIR__ . '/../../views/admin/inventory/form.php';
    }

    // Handle update POST
    public function update($id) {
        $data = [
            'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
            'price' => isset($_POST['price']) ? trim($_POST['price']) : 0,
            'description' => isset($_POST['description']) ? trim($_POST['description']) : '',
            'quantity' => isset($_POST['quantity']) ? intval($_POST['quantity']) : 0,
        ];

        if ($data['name'] === '') {
            $_SESSION['error'] = 'Name is required';
            header('Location: admin.php?controller=inventory&action=edit&id=' . intval($id));
            exit;
        }

        $this->inventory->update($id, $data);
        header('Location: admin.php?controller=inventory');
        exit;
    }

    // Delete inventory item
    public function delete($id) {
        $this->inventory->delete($id);
        header('Location: admin.php?controller=inventory');
        exit;
    }
}
