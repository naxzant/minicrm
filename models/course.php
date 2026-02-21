<?php
require_once '../core/Model.php';

class Course extends Model {

    // Get all courses
    public function all() {
        return $this->db->query("SELECT * FROM courses")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find single course by ID
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE course_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create new course
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO courses(course_name, course_code, duration, fees)
            VALUES(?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['course_name'],
            $data['course_code'],
            $data['duration'],
            $data['fees']
        ]);
    }

    // Update course
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE courses 
            SET course_name = ?, 
                course_code = ?, 
                duration = ?, 
                fees = ?
            WHERE course_id = ?
        ");

        return $stmt->execute([
            $data['course_name'],
            $data['course_code'],
            $data['duration'],
            $data['fees'],
            $id
        ]);
    }

    // Delete course
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE course_id = ?");
        return $stmt->execute([$id]);
    }

    // ======================================
    // NEW: Check duplicate course code (Create)
    // ======================================
    public function codeExists($code) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM courses 
            WHERE course_code = ?
        ");
        $stmt->execute([$code]);
        return $stmt->fetchColumn() > 0;
    }

    // ======================================
    // NEW: Check duplicate during Update
    // ======================================
    public function codeExistsForUpdate($code, $id) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM courses 
            WHERE course_code = ? 
            AND course_id != ?
        ");
        $stmt->execute([$code, $id]);
        return $stmt->fetchColumn() > 0;
    }

    // ======================================
    // NEW: Auto Generate Next Course Code
    // ======================================
    public function getNextCode() {
        $stmt = $this->db->query("
            SELECT MAX(course_id) as max_id FROM courses
        ");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $next = ($row['max_id'] ?? 0) + 1;

        return 'CRS20' . str_pad($next, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Return filtered and sorted courses
     * Accepts: course_name, max_fees, sort, dir
     */
    public function getFiltered(array $opts = []) {

        $allowedSort = ['course_id','course_name','course_code','fees','created_at'];
        $where = [];
        $params = [];

        // Filter by course name
        if (!empty($opts['course_name'])) {
            $where[] = 'course_name LIKE ?';
            $params[] = '%' . $opts['course_name'] . '%';
        }
             // Filter by course code
        if (!empty($opts['course_code'])) {
             $where[] = 'course_code LIKE ?';
             $params[] = '%' . $opts['course_code'] . '%';
}

        // Filter by max fees
        if (isset($opts['max_fees']) && $opts['max_fees'] !== '') {
            if (is_numeric($opts['max_fees'])) {
                $where[] = 'fees <= ?';
                $params[] = $opts['max_fees'];
            }
        }

        $sql = "SELECT * FROM courses";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        // Sorting
        $sort = in_array($opts['sort'] ?? '', $allowedSort)
                ? $opts['sort']
                : 'course_id';

        $dir = strtoupper($opts['dir'] ?? 'ASC') === 'DESC'
                ? 'DESC'
                : 'ASC';

        $sql .= " ORDER BY {$sort} {$dir}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>