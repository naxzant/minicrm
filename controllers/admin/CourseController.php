<?php
require_once __DIR__ . '/../../models/course.php';

class CourseController {

    protected $course;

    public function __construct() {
        $this->course = new Course();
    }

    // ===============================
    // LIST COURSES (with filter + sort)
    // ===============================
    public function index() {

        $opts = [];
        $opts['course_name'] = $_GET['course_name'] ?? '';
        $opts['course_code'] = $_GET['course_code'] ?? '';
        $opts['sort'] = $_GET['sort'] ?? 'course_id';
        $opts['dir'] = $_GET['dir'] ?? 'ASC';

        $courses = $this->course->getFiltered($opts);

        require __DIR__ . '/../../views/admin/course/index.php';
    }

    // ===============================
    // SHOW CREATE FORM
    // ===============================
    public function create() {

        $course = [
            'course_name' => '',
            'course_code' => '',
            'duration'    => '',
            'fees'        => ''
        ];

        $action = 'store';

        require __DIR__ . '/../../views/admin/course/form.php';
    }

    // ===============================
    // STORE COURSE
    // ===============================
    public function store() {

        $data = [
            'course_name' => trim($_POST['course_name'] ?? ''),
            'course_code' => trim($_POST['course_code'] ?? ''),
            'duration'    => trim($_POST['duration'] ?? ''),
            'fees'        => trim($_POST['fees'] ?? 0),
        ];

        // Required validation
        if ($data['course_name'] === '' || $data['course_code'] === '') {
            $_SESSION['error'] = 'Course Name and Course Code are required';
            header('Location: admin.php?controller=course&action=create');
            exit;
        }

        // Duplicate validation
        if ($this->course->codeExists($data['course_code'])) {
            $_SESSION['error'] = 'Course Code already exists';
            header('Location: admin.php?controller=course&action=create');
            exit;
        }

        $this->course->create($data);

        $_SESSION['success'] = 'Course Added Successfully';

        header('Location: admin.php?controller=course');
        exit;
    }

    // ===============================
    // SHOW EDIT FORM
    // ===============================
    public function edit($id) {

        $course = $this->course->find($id);

        if (!$course) {
            die("Course not found");
        }

        $action = 'update';

        require __DIR__ . '/../../views/admin/course/form.php';
    }

    // ===============================
    // UPDATE COURSE
    // ===============================
    public function update($id) {

        $data = [
            'course_name' => trim($_POST['course_name'] ?? ''),
            'course_code' => trim($_POST['course_code'] ?? ''),
            'duration'    => trim($_POST['duration'] ?? ''),
            'fees'        => trim($_POST['fees'] ?? '')
        ];

        // Required validation
        if ($data['course_name'] === '' || $data['course_code'] === '') {
            $_SESSION['error'] = 'Course Name and Course Code are required';
            header("Location: admin.php?controller=course&action=edit&id=$id");
            exit;
        }

        // Duplicate check except current record
        if ($this->course->codeExistsForUpdate($data['course_code'], $id)) {
            $_SESSION['error'] = 'Course Code already exists';
            header("Location: admin.php?controller=course&action=edit&id=$id");
            exit;
        }

        $this->course->update($id, $data);

        $_SESSION['success'] = 'Course Updated Successfully';

        header("Location: admin.php?controller=course");
        exit;
    }

    // ===============================
    // DELETE COURSE
    // ===============================
    public function delete($id) {

        $this->course->delete($id);

        $_SESSION['success'] = 'Course Deleted Successfully';

        header('Location: admin.php?controller=course');
        exit;
    }
}
?>