<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$title = 'Products';
ob_start();
?>

<h2>Products</h2>
<?php if (!empty($_SESSION['error'])): ?>
    <div style="color:red"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
<?php endif; ?>
<p><a href="admin.php?controller=product&action=create">Create New Product</a></p>

<form method="get" action="admin.php" class="mb-3">
    <input type="hidden" name="controller" value="product">
    <label>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($_GET['name'] ?? ''); ?>"></label>
    <label>Price (max): <input type="text" name="price" value="<?php echo htmlspecialchars($_GET['price'] ?? ''); ?>"></label>
    <button type="submit">Filter</button>
    <a href="admin.php?controller=product">Reset</a>
</form>

<table border="1" cellpadding="6" cellspacing="0" width="100%">
    <thead>
        <tr>
            <?php
            function sort_link($col, $label) {
                $qs = $_GET;
                $qs['controller'] = 'product';
                $currentSort = $_GET['sort'] ?? 'id';
                $currentDir = strtoupper($_GET['dir'] ?? 'ASC');
                if ($currentSort === $col) {
                    $qs['dir'] = ($currentDir === 'ASC') ? 'DESC' : 'ASC';
                } else {
                    $qs['dir'] = 'ASC';
                }
                $qs['sort'] = $col;
                $url = 'admin.php?' . http_build_query($qs);
                return '<a href="' . htmlspecialchars($url) . '">' . htmlspecialchars($label) . '</a>';
            }
            ?>
            <th><?php echo sort_link('id','ID'); ?></th>
            <th><?php echo sort_link('name','Name'); ?></th>
            <th><?php echo sort_link('price','Price'); ?></th>
            <th><?php echo sort_link('created_at','Created'); ?></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($products)): foreach ($products as $p): ?>
        <tr>
            <td><?php echo htmlspecialchars($p['id']); ?></td>
            <td><?php echo htmlspecialchars($p['name']); ?></td>
            <td><?php echo htmlspecialchars($p['price']); ?></td>
            <td><?php echo htmlspecialchars($p['created_at'] ?? ''); ?></td>
            <td>
                <a href="admin.php?controller=product&action=edit&id=<?php echo $p['id']; ?>">Edit</a>
                |
                <a href="admin.php?controller=product&action=delete&id=<?php echo $p['id']; ?>" onclick="return confirm('Delete this product?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; else: ?>
        <tr><td colspan="5">No products found.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
