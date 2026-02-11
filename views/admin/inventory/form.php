<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$title = ($action === 'store') ? 'Add Inventory Item' : 'Edit Inventory Item';
ob_start();
?>

<style>
 /* Inventory module form css start  */
/* ===== Modern Inventory Form ===== */

.inv-form-module {
    display: flex;
    justify-content: center;
    padding: 40px 20px;
    background: #f1f5f9;
    min-height: 80vh;
    font-family: 'Segoe UI', Arial, sans-serif;
}

.inv-form-module h2 {
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: 600;
    color: #1e293b;
}

/* Form Card */
.inv-form-module .inv-form {
    width: 100%;
    max-width: 520px;
    background: #ffffff;
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

/* Labels */
.inv-form-module .inv-form-label {
    display: block;
    margin-top: 18px;
    font-size: 14px;
    font-weight: 600;
    color: #334155;
}

/* Inputs & Textarea */
.inv-form-module .inv-form-input,
.inv-form-module .inv-form-description {
    width: 100%;
    padding: 10px 12px;
    margin-top: 6px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    font-size: 14px;
    transition: all 0.2s ease;
    outline: none;
    box-sizing: border-box;
    background: #f8fafc;
}

.inv-form-module .inv-form-input:focus,
.inv-form-module .inv-form-description:focus {
    border-color: #2563eb;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

/* Buttons */
.inv-form-module .inv-form-btn {
    margin-top: 20px;
    padding: 10px 18px;
    background: #2563eb;
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: 0.2s ease;
}

.inv-form-module .inv-form-btn:hover {
    background: #1d4ed8;
}

/* Cancel link */
.inv-form-module a {
    margin-left: 12px;
    color: #475569;
    text-decoration: none;
    font-size: 14px;
}

.inv-form-module a:hover {
    text-decoration: underline;
}

/* Error Message */
.inv-form-module .inv-form-error {
    background: #fee2e2;
    color: #b91c1c;
    padding: 10px 12px;
    border-radius: 6px;
    margin-bottom: 15px;
    font-size: 14px;
}

</style>

 <!-- Inventory module from end -->

<div class="inv-form-module">



<h2><?php echo ($action === 'store') ? 'Add Inventory Item' : 'Edit Inventory Item'; ?></h2>


<?php if (!empty($_SESSION['error'])): ?>
    <div class="inv-form-error">

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
    <input type="number"
           class="inv-form-input"
           id="price"
           name="price"
           min="0"
           value="<?php echo htmlspecialchars($item['price'] ?? ''); ?>">

    <label for="quantity" class="inv-form-label">Quantity</label>
    <input type="number"
           class="inv-form-input"
           id="quantity"
           name="quantity"
           min="0"
           required
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

<script>
document.addEventListener("DOMContentLoaded", function() {

    const form = document.querySelector('.inv-form');
    const nameInput = document.getElementById('name');
    const priceInput = document.getElementById('price');
    const quantityInput = document.getElementById('quantity');

    // Create error container
    const errorBox = document.createElement('div');
    errorBox.className = 'inv-form-error';
    errorBox.style.display = 'none';
    form.prepend(errorBox);

    function showError(message) {
        errorBox.innerText = message;
        errorBox.style.display = 'block';
    }

    function clearError() {
        errorBox.style.display = 'none';
        errorBox.innerText = '';
    }

    function markInvalid(input) {
        input.style.borderColor = "#dc2626";
        input.style.backgroundColor = "#fee2e2";
    }

    function clearInvalid(input) {
        input.style.borderColor = "";
        input.style.backgroundColor = "";
    }

    form.addEventListener('submit', function(e) {
        clearError();
        clearInvalid(nameInput);
        clearInvalid(priceInput);
        clearInvalid(quantityInput);

        let name = nameInput.value.trim();
        let price = priceInput.value.trim();
        let quantity = quantityInput.value.trim();

        let namePattern = /^[A-Za-z ]+$/;

        if (!namePattern.test(name)) {
            e.preventDefault();
            showError("Name must contain only letters.");
            markInvalid(nameInput);
            return;
        }

        if (price === "" || isNaN(price) || Number(price) < 0) {
            e.preventDefault();
            showError("Price must be a valid positive number.");
            markInvalid(priceInput);
            return;
        }

        if (quantity === "" || isNaN(quantity) || Number(quantity) < 0) {
            e.preventDefault();
            showError("Quantity must be a valid positive number.");
            markInvalid(quantityInput);
            return;
        }
    });

});
</script>


</div>


<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
