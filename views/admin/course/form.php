<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$title = ($action === 'store') ? 'Create Course' : 'Edit Course';
ob_start();
?>

<h2><?php echo ($action === 'store') ? 'Create Course' : 'Edit Course'; ?></h2>

<?php if (!empty($_SESSION['error'])): ?>
    <div style="color:red">
        <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form  method="post"
 onsubmit="return validateCourseForm();"
      action="admin.php?controller=course&action=<?php echo $action; ?>">

    <?php if ($action === 'update' && !empty($course['course_id'])): ?>
        <input type="hidden" name="course_id"
               value="<?php echo intval($course['course_id']); ?>">
    <?php endif; ?>

    <label for="course_name">Course Name</label>
    <input type="text" id="course_name" name="course_name"
           value="<?php echo htmlspecialchars($course['course_name'] ?? ''); ?>"
           required>

    <label for="course_code">Course Code</label>
    <input type="text" id="course_code" name="course_code"
           value="<?php echo htmlspecialchars($course['course_code'] ?? ''); ?>"
           required>

    <label for="duration">Duration</label>
    <select id="duration" name="duration">
        <option value="">-- Select Duration --</option>
        <option value="1 Months" <?php if(($course['duration'] ?? '') === '3 Months') echo 'selected'; ?>>3 Months</option>
        <option value="2 Months" <?php if(($course['duration'] ?? '') === '6 Months') echo 'selected'; ?>>6 Months</option>
        <option value="6 months" <?php if(($course['duration'] ?? '') === '1 Year') echo 'selected'; ?>>1 Year</option>
    </select>

    <label for="fees">Fees</label>
    <input type="text" id="fees" name="fees"
           value="<?php echo htmlspecialchars($course['fees'] ?? ''); ?>">

    <p>
        <button type="submit">
            <?php echo ($action === 'store') ? 'Create' : 'Update'; ?>
        </button>
        <a href="admin.php?controller=course">Cancel</a>
    </p>
</form>

<style>

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #2c3e50;
}

form {
    width: 420px;
    margin: 20px auto;
    padding: 25px;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
}

label {
    display: block;
    margin-top: 12px;
    font-weight: 600;
    color: #34495e;
}

input, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

input:focus, select:focus {
    border-color: #3498db;
    outline: none;
}

button {
    margin-top: 15px;
    padding: 8px 15px;
    background-color: #3498db;
    border: none;
    color: white;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #2980b9;
}

a {
    margin-left: 10px;
    text-decoration: none;
    color: #e74c3c;
    font-weight: 500;
}

a:hover {
    text-decoration: underline;
}

div[style*="color:red"] {
    text-align: center;
    font-weight: bold;
    margin-bottom: 10px;
}

@media (max-width: 768px) {
    form {
        width: 90%;
        padding: 20px;
    }
}

/* Mobile */
@media (max-width: 480px) {

    form {
        width: 95%;
        padding: 15px;
    }

    h2 {
        font-size: 20px;
    }

    button {
        width: 100%;
        margin-top: 10px;
    }

    a {
        display: block;
        margin: 10px 0 0 0;
        text-align: center;
    }
}

</style>




<script>
function validateCourseForm() {

    var name = document.getElementById("course_name").value.trim();
    var code = document.getElementById("course_code").value.trim();
    var duration = document.getElementById("duration").value;
    var fees = document.getElementById("fees").value.trim();

    // Course Name Required
    if (name === "") {
        alert("Course Name is required!");
        return false;
    }

    // Course Name should not contain numbers
    if (/[0-9]/.test(name)) {
        alert("Course Name should not contain numbers!");
        return false;
    }

    // Course Code Required
    if (code === "") {
        alert("Course Code is required!");
        return false;
    }

    // Course Code format (only letters & numbers)
    if (!/^[A-Za-z0-9]+$/.test(code)) {
        alert("Course Code must contain only letters and numbers!");
        return false;
    }

    // Duration Required
    if (duration === "") {
        alert("Please select Duration!");
        return false;
    }

    // Fees Required
    if (fees === "") {
        alert("Fees is required!");
        return false;
    }

    // Fees must be number
    if (isNaN(fees)) {
        alert("Fees must be a number!");
        return false;
    }

    // Fees must be positive
    if (parseFloat(fees) <= 0) {
        alert("Fees must be greater than 0!");
        return false;
    }

    return true; // Allow submission if all valid
}
</script>


<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>