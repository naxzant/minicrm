<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$title = 'Inventory';
ob_start();
?>

<style>
/* Inventory module start */
/* ===== Modern Inventory Module ===== */

.inv-module {
    background: #f8fafc;
    padding: 25px;
    border-radius: 12px;
    font-family: 'Segoe UI', Arial, sans-serif;
}

/* Title */
.inv-module h2 {
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: 600;
    color: #1e293b;
}

/* Add Button */
.inv-module .inv-add-link {
    display: inline-block;
    margin-bottom: 18px;
    padding: 8px 14px;
    background: #2563eb;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    transition: 0.2s ease;
}

.inv-module .inv-add-link:hover {
    background: #1d4ed8;
}

/* Filter Box */
.inv-module .inv-filter {
    margin-bottom: 20px;
    padding: 15px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.inv-module .inv-filter label {
    margin-right: 15px;
    font-size: 14px;
    color: #334155;
}

.inv-module .inv-filter input {
    padding: 6px 8px;
    border-radius: 6px;
    border: 1px solid #d1d5db;
    margin-left: 5px;
    outline: none;
}

.inv-module .inv-filter input:focus {
    border-color: #2563eb;
}

/* Filter Button */
.inv-module .inv-btn {
    padding: 6px 14px;
    background: #0f172a;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s ease;
}

.inv-module .inv-btn:hover {
    background: #1e293b;
}

/* Table */
.inv-module .inv-table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 12px rgba(0,0,0,0.06);
}

.inv-module .inv-table thead {
    background: #1e293b;
    color: #ffffff;
}

.inv-module .inv-table th,
.inv-module .inv-table td {
    padding: 12px 14px;
    font-size: 14px;
}

.inv-module .inv-table th {
    font-weight: 500;
}

.inv-module .inv-table tbody tr {
    transition: background 0.2s ease;
}

.inv-module .inv-table tbody tr:nth-child(even) {
    background: #f1f5f9;
}

.inv-module .inv-table tbody tr:hover {
    background: #e2e8f0;
}

/* Sort Links */
.inv-module .inv-table th a {
    color: #ffffff;
    text-decoration: none;
}

.inv-module .inv-table th a:hover {
    text-decoration: underline;
}

/* Actions */
.inv-module .inv-actions a {
    padding: 4px 8px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 13px;
    margin-right: 6px;
    transition: 0.2s ease;
}

.inv-module .inv-actions a:first-child {
    background: #2563eb;
    color: #fff;
}

.inv-module .inv-actions a:first-child:hover {
    background: #1d4ed8;
}

.inv-module .inv-actions a:last-child {
    background: #dc2626;
    color: #fff;
}

.inv-module .inv-actions a:last-child:hover {
    background: #b91c1c;
}

/* ===== Delete Modal ===== */

.inv-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 999;
}

.inv-modal {
    background: #ffffff;
    padding: 25px;
    width: 100%;
    max-width: 400px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    text-align: center;
    animation: fadeIn 0.2s ease;
}

.inv-modal h3 {
    margin-bottom: 10px;
    color: #1e293b;
}

.inv-modal p {
    margin-bottom: 20px;
    font-size: 14px;
    color: #475569;
}

.inv-modal-buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.inv-btn-cancel {
    padding: 8px 14px;
    background: #e2e8f0;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.inv-btn-confirm {
    padding: 8px 14px;
    background: #dc2626;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.inv-btn-confirm:hover {
    background: #b91c1c;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
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

<!-- Delete Modal -->
<div class="inv-modal-overlay" id="deleteModal">
    <div class="inv-modal">
        <h3>Delete Item</h3>
        <p>Are you sure you want to delete this inventory item?</p>
        <div class="inv-modal-buttons">
            <button class="inv-btn-cancel" id="cancelDelete">Cancel</button>
            <button class="inv-btn-confirm" id="confirmDelete">Delete</button>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const modal = document.getElementById("deleteModal");
    const cancelBtn = document.getElementById("cancelDelete");
    const confirmBtn = document.getElementById("confirmDelete");
    let deleteUrl = null;

    // Attach to all delete links
    document.querySelectorAll('.inv-actions a:last-child').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            deleteUrl = this.href;
            modal.style.display = "flex";
        });
    });

    cancelBtn.addEventListener('click', function () {
        modal.style.display = "none";
        deleteUrl = null;
    });

    confirmBtn.addEventListener('click', function () {
        if (deleteUrl) {
            window.location.href = deleteUrl;
        }
    });

    // Close modal when clicking outside
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

});
</script>


</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
