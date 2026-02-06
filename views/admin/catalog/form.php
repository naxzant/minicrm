<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$title = ($action === 'store') ? 'Create Product' : 'Edit Product';
ob_start();
?>

<h2><?php echo ($action === 'store') ? 'Create Product' : 'Edit Product'; ?></h2>
<?php if (!empty($_SESSION['error'])): ?>
    <div style="color:red"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>

<form method="post" action="admin.php?controller=product&action=<?php echo $action; ?><?php echo ($action === 'update' && !empty($product['id'])) ? '&id=' . intval($product['id']) : ''; ?>">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>

    <label for="price">Price</label>
    <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>">

    <label for="description">Description</label>
    <textarea id="description" name="description" rows="6"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>

    <p>
        <button type="submit"><?php echo ($action === 'store') ? 'Create' : 'Update'; ?></button>
        <a href="admin.php?controller=product">Cancel</a>
    </p>
</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
