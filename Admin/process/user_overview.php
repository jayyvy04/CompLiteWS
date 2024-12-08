<?php
// process/user_overview.php
require_once '../config/database.php';

class UserOverview {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUserStatistics() {
        $statistics = [
            'students' => 0,
            'instructors' => 0,
            'admins' => 0,
            'totalUsers' => 0
        ];

        // Get student count
        $studentQuery = "SELECT COUNT(*) as count FROM student_profile";
        $studentResult = $this->db->conn->query($studentQuery);
        $statistics['students'] = $studentResult->fetch_assoc()['count'];

        // Get instructor count
        $instructorQuery = "SELECT COUNT(*) as count FROM instructor_profile";
        $instructorResult = $this->db->conn->query($instructorQuery);
        $statistics['instructors'] = $instructorResult->fetch_assoc()['count'];

        // Get admin count
        $adminQuery = "SELECT COUNT(*) as count FROM admin";
        $adminResult = $this->db->conn->query($adminQuery);
        $statistics['admins'] = $adminResult->fetch_assoc()['count'];

        $statistics['totalUsers'] = $statistics['students'] + $statistics['instructors'] + $statistics['admins'];

        return $statistics;
    }

    public function getCourseStatistics() {
        $statistics = [
            'totalCourses' => 0,
            'activeCourses' => 0,
            'pendingCourses' => 0
        ];

        // Get total courses
        $totalCoursesQuery = "SELECT COUNT(*) as count FROM section";
        $totalCoursesResult = $this->db->conn->query($totalCoursesQuery);
        $statistics['totalCourses'] = $totalCoursesResult->fetch_assoc()['count'];

        // Note: This is a simplified example. You might want to define 'active' and 'pending' more specifically
        $statistics['activeCourses'] = $statistics['totalCourses'] - 2;  // Example logic
        $statistics['pendingCourses'] = 2;  // Example logic

        return $statistics;
    }
}