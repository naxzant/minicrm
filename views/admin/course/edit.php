<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .container {
            width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #0b5ed7;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Course</h2>

    <form method="POST" action="admin.php?controller=course&action=update&id=<?php echo $course['course_id']; ?>">

        <label>Course Name</label>
        <input type="text" name="course_name"
            value="<?php echo htmlspecialchars($course['course_name']); ?>" required>

        <label>Course Code</label>
        <input type="text" name="course_code"
            value="<?php echo htmlspecialchars($course['course_code']); ?>" required>

        <label>Duration</label>
        <input type="text" name="duration"
            value="<?php echo htmlspecialchars($course['duration']); ?>">

        <label>Fees</label>
        <input type="number" step="0.01" name="fees"
            value="<?php echo htmlspecialchars($course['fees']); ?>">

        <button type="submit">Update Course</button>

    </form>
</div>

</body>
</html>
