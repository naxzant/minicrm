<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$title = 'Inventory';
ob_start();
?>

<style>
/* Inventory module start */

.inv-module h2 {
    margin-bottom: 12px;
}

.inv-module .inv-add-link {
    display: inline-block;
    margin-bottom: 10px;
    color: #1d4ed8;
    font-weight: 500;
    text-decoration: none;
}

.inv-module .inv-add-link:hover {
    text-decoration: underline;
}

.inv-module .inv-filter {
    margin-bottom: 15px;
    padding: 10px;
    background-color: #f8fafc;
    border: 1px solid #ddd;
}

.inv-module .inv-filter label {
    margin-right: 12px;
    font-size: 14px;
}

.inv-module .inv-btn {
    padding: 4px 10px;
    cursor: pointer;
}

.inv-module .inv-table {
    border-collapse: collapse;
    background-color: #fff;
}

.inv-module .inv-table th {
    background-color: #f1f5f9;
    text-align: left;
}

.inv-module .inv-table th,
.inv-module .inv-table td {
    padding: 8px;
    font-size: 14px;
}

.inv-module .inv-table tr:nth-child(even) {
    background-color: #f9fafb;
}

.inv-module .inv-actions a {
    color: #2563eb;
    text-decoration: none;
    margin-right: 6px;
}

.inv-module .inv-actions a:hover {
    text-decoration: underline;
}
</style>

<!--  Inventory module end  -->

<div class="inv-module">


<h2>Inventory</h2>

<?php if (!empty($_SESSION['error'])): ?>
    <div style="color:red">
        <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<p>
    <a href="admin.php?controller=inventory&action=create" class="inv-add-link">
        Add Inventory Item
    </a>
</p>

<form method="get" action="admin.php" class="inv-filter">
    <input type="hidden" name="controller" value="inventory">

    <label>
        Name:
        <input type="text" name="name"
            value="<?php echo htmlspecialchars($_GET['name'] ?? ''); ?>">
    </label>

    <label>
        Price (max):
        <input type="text" name="price"
            value="<?php echo htmlspecialchars($_GET['price'] ?? ''); ?>">
    </label>

    <label>
        Quantity (max):
        <input type="text" name="quantity"
            value="<?php echo htmlspecialchars($_GET['quantity'] ?? ''); ?>">
    </label>

    <button type="submit" class="inv-btn">Filter</button>
    <a href="admin.php?controller=inventory">Reset</a>
</form>

<table class="inv-table" border="1" cellpadding="6" cellspacing="0" width="100%">
    <thead>
        <tr>
            <?php
            function sort_link($col, $label) {
                $qs = $_GET;
                $qs['controller'] = 'inventory';

                $currentSort = $_GET['sort'] ?? 'id';
                $currentDir  = strtoupper($_GET['dir'] ?? 'ASC');

                if ($currentSort === $col) {
                    $qs['dir'] = ($currentDir === 'ASC') ? 'DESC' : 'ASC';
                } else {
                    $qs['dir'] = 'ASC';
                }

                $qs['sort'] = $col;
                $url = 'admin.php?' . http_build_query($qs);

                return '<a href="' . htmlspecialchars($url) . '">' .
                        htmlspecialchars($label) . '</a>';
            }
            ?>
            <th><?php echo sort_link('id', 'ID'); ?></th>
            <th><?php echo sort_link('name', 'Name'); ?></th>
            <th><?php echo sort_link('price', 'Price'); ?></th>
            <th><?php echo sort_link('quantity', 'Quantity'); ?></th>
            <th><?php echo sort_link('created_at', 'Created'); ?></th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
    <?php if (!empty($items)): foreach ($items as $item): ?>
        <tr>
            <td ><?php echo htmlspecialchars($item['id']); ?></td>
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td><?php echo htmlspecialchars($item['price']); ?></td>
            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
            <td><?php echo htmlspecialchars($item['created_at'] ?? ''); ?></td>
            <td class="inv-actions">
                <a href="admin.php?controller=inventory&action=edit&id=<?php echo $item['id']; ?>">
                    Edit
                </a>
                |
                <a href="admin.php?controller=inventory&action=delete&id=<?php echo $item['id']; ?>"
                   onclick="return confirm('Delete this inventory item?')">
                    Delete
                </a>
            </td>
        </tr>
    <?php endforeach; else: ?>
        <tr>
            <td colspan="6">No inventory items found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
