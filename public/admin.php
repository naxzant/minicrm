<?php
// Minimal admin router
if (session_status() === PHP_SESSION_NONE) session_start();

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'dashboard';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// auth controller allowed without session
if ($controller === 'auth') {
    require __DIR__ . '/../controllers/admin/AuthController.php';
    $auth = new AuthController();
    if ($action === 'login') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $auth->login(); else $auth->showLogin();
    } elseif ($action === 'logout') {
        $auth->logout();
    } else {
        $auth->showLogin();
    }
    exit;
}

// require authentication
if (empty($_SESSION['admin_authenticated'])) {
    header('Location: admin.php?controller=auth&action=login');
    exit;
}

switch ($controller) {
    case 'dashboard':
        require __DIR__ . '/../views/admin/dashboard.php';
        break;
    case 'product':
        require __DIR__ . '/../controllers/admin/ProductController.php';
        $c = new ProductController();

        if (in_array($action, ['edit','update','delete'])) {
            $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
            if ($action === 'edit') $c->edit($id);
            elseif ($action === 'update') $c->update($id);
            elseif ($action === 'delete') $c->delete($id);
            break;
        }

        if ($action === 'create') {
            $c->create();
        } elseif ($action === 'store') {
            $c->store();
        } else {
            $c->index();
        }

        break;
    default:
        header('HTTP/1.0 404 Not Found');
        echo 'Not Found';
}

?>
