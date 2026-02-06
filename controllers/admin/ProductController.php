<?php

require_once __DIR__ . '/../../models/Product.php';

class ProductController {

    protected $product;

    public function __construct() {
        $this->product = new Product();
    }

    // List products (grid)
    public function index() {
        // read filter and sort params from GET
        $opts = [];
        $opts['name'] = isset($_GET['name']) ? trim($_GET['name']) : '';
        $opts['price'] = isset($_GET['price']) ? trim($_GET['price']) : '';
        $opts['sort'] = isset($_GET['sort']) ? trim($_GET['sort']) : 'id';
        $opts['dir'] = isset($_GET['dir']) ? trim($_GET['dir']) : 'ASC';

        $products = $this->product->getFiltered($opts);
        require __DIR__ . '/../../views/admin/catalog/index.php';
    }

    // Show create form
    public function create() {
        $product = ['name' => '', 'price' => '', 'description' => ''];
        $action = 'store';
        require __DIR__ . '/../../views/admin/catalog/form.php';
    }

    // Handle store POST
    public function store() {
        $data = [
            'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
            'price' => isset($_POST['price']) ? trim($_POST['price']) : 0,
            'description' => isset($_POST['description']) ? trim($_POST['description']) : '',
        ];

        // basic validation
        if ($data['name'] === '') {
            $_SESSION['error'] = 'Name is required';
            header('Location: admin.php?controller=product&action=create');
            exit;
        }

        $this->product->create($data);
        header('Location: admin.php?controller=product');
        exit;
    }

    // Show edit form
    public function edit($id) {
        $product = $this->product->find($id);
        if (!$product) {
            header('Location: admin.php?controller=product');
            exit;
        }
        $action = 'update';
        require __DIR__ . '/../../views/admin/catalog/form.php';
    }

    // Handle update POST
    public function update($id) {
        $data = [
            'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
            'price' => isset($_POST['price']) ? trim($_POST['price']) : 0,
            'description' => isset($_POST['description']) ? trim($_POST['description']) : '',
        ];

        if ($data['name'] === '') {
            $_SESSION['error'] = 'Name is required';
            header('Location: admin.php?controller=product&action=edit&id=' . intval($id));
            exit;
        }

        $this->product->update($id, $data);
        header('Location: admin.php?controller=product');
        exit;
    }

    // Delete
    public function delete($id) {
        $this->product->delete($id);
        header('Location: admin.php?controller=product');
        exit;
    }
}

?>