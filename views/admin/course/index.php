<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$title = 'Courses';
ob_start();
?>

<h2>Courses</h2>

<!-- POPUP MESSAGES -->
<?php if (!empty($_SESSION['error'])): ?>
<script>
alert("<?= htmlspecialchars($_SESSION['error']) ?>");
</script>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
<script>
alert("<?= htmlspecialchars($_SESSION['success']) ?>");
</script>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>

<p>
    <a href="admin.php?controller=course&action=create">
        Create New Course
    </a>
</p>

<!-- FILTER FORM -->
<form method="get" action="admin.php">
    <input type="hidden" name="controller" value="course">

    <label>
        Course Name:
        <input type="text" name="course_name"
               value="<?= htmlspecialchars($_GET['course_name'] ?? '') ?>">
    </label>

    <label>
        Course Code:
        <input type="text" name="course_code"
               value="<?= htmlspecialchars($_GET['course_code'] ?? '') ?>">
    </label>

    <button type="submit">Filter</button>
    <a href="admin.php?controller=course">Reset</a>
</form>

<?php
// Sorting function
function sort_link($col, $label) {

    $qs = $_GET;
    $qs['controller'] = 'course';

    $currentSort = $_GET['sort'] ?? 'course_id';
    $currentDir  = strtoupper($_GET['dir'] ?? 'ASC');

    $qs['sort'] = $col;
    $qs['dir']  = ($currentSort === $col && $currentDir === 'ASC') ? 'DESC' : 'ASC';

    return '<a href="admin.php?' . http_build_query($qs) . '">' . $label . '</a>';
}
?>

<!-- COURSE TABLE -->
<table border="1" cellpadding="6" cellspacing="0" width="100%">
<thead>
<tr>
    <th><?= sort_link('course_id','ID') ?></th>
    <th><?= sort_link('course_name','Course Name') ?></th>
    <th><?= sort_link('course_code','Course Code') ?></th>
    <th><?= sort_link('duration','Duration') ?></th>
    <th><?= sort_link('fees','Fees') ?></th>
    <th><?= sort_link('created_at','Created') ?></th>
    <th>Actions</th>
</tr>
</thead>

<tbody>
<?php if (!empty($courses)): ?>
<?php foreach ($courses as $c): ?>
<tr>
    <td><?= htmlspecialchars($c['course_id']) ?></td>
    <td><?= htmlspecialchars($c['course_name']) ?></td>
    <td><?= htmlspecialchars($c['course_code']) ?></td>
    <td><?= htmlspecialchars($c['duration']) ?></td>
    <td><?= htmlspecialchars($c['fees']) ?></td>
    <td><?= htmlspecialchars($c['created_at'] ?? '') ?></td>
    <td>
        <a href="admin.php?controller=course&action=edit&id=<?= urlencode($c['course_id']) ?>">
            Update
        </a>
        |
        <a href="admin.php?controller=course&action=delete&id=<?= urlencode($c['course_id']) ?>"
           onclick="return confirm('Delete this course?')">
            Delete
        </a>
    </td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="7">No courses found.</td>
</tr>
<?php endif; ?>
</tbody>
</table>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>