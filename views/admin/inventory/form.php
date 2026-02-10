<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$title = ($action === 'store') ? 'Add Inventory Item' : 'Edit Inventory Item';
ob_start();
?>

<style>
 /* Inventory module form css start  */

.inv-form-module .inv-form {
    max-width: 480px;
}

.inv-form-module .inv-form-label {
    display: block;
    margin-top: 10px;
    font-weight: 500;
}

.inv-form-module .inv-form-input,
.inv-form-module .inv-form-description {
    width: 100%;
    padding: 6px;
    margin-top: 4px;
    box-sizing: border-box;
}

.inv-form-module .inv-form-btn {
    padding: 6px 14px;
}

.inv-form-module .inv-form-error {
    color: red;
    margin-bottom: 10px;
}
</style>

 <!-- Inventory module from end -->

<div class="inv-form-module">



<h2><?php echo ($action === 'store') ? 'Add Inventory Item' : 'Edit Inventory Item'; ?></h2>

<?php if (!empty($_SESSION['error'])): ?>
    <div style="color:red">
        <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form method="post" class="inv-form" action="admin.php?controller=inventory&action=<?php echo $action; ?><?php echo ($action === 'update' && !empty($item['id'])) ? '&id=' . intval($item['id']) : ''; ?>">


    <label for="name" class="inv-form-label">Name</label>
    <input type="text"
         class="inv-form-input"
           id="name"
           name="name"
           value="<?php echo htmlspecialchars($item['name'] ?? ''); ?>"
           required>

    <label for="price" class="inv-form-label">Price</label>
    <input type="text"
           class="inv-form-input"
           id="price"
           name="price"
           value="<?php echo htmlspecialchars($item['price'] ?? ''); ?>">

    <label for="quantity" class="inv-form-label">Quantity</label>
    <input type="number"
           class="inv-form-input"
           id="quantity"
           name="quantity"
           min="0"
           value="<?php echo htmlspecialchars($item['quantity'] ?? 0); ?>">

    <label for="description" class="inv-form-label">Description</label>
    <textarea id="description"
                class="inv-form-description"
              name="description"
              rows="6"><?php echo htmlspecialchars($item['description'] ?? ''); ?></textarea>

    <p>
        <button type="submit" class="inv-form-btn">
            <?php echo ($action === 'store') ? 'Add Item' : 'Update Item'; ?>
        </button>
        <a href="admin.php?controller=inventory">Cancel</a>
    </p>
</form>

</div>


<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
