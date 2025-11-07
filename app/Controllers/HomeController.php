<?php
namespace App\Controllers;

use App\Core\{Auth, Session};
use App\Models\{Semester, MiniLibrary};
use PDO, PDOException;

class HomeController {
    private PDO $pdo;
    private Semester $sem;
    private MiniLibrary $miniLib;

    public function __construct() {
        if (!isset($GLOBALS['pdo']) || !$GLOBALS['pdo'] instanceof PDO) {
            $host = DB_HOST;
            $dbname = DB_NAME;
            $username = DB_USER;
            $password = DB_PASS;
            try {
                $pdo = new PDO(
                    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                    $username, $password,
                    [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ]
                );
                $GLOBALS['pdo'] = $pdo;
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        $this->pdo = $GLOBALS['pdo'];
        $this->sem = new Semester($this->pdo);
        $this->miniLib = new MiniLibrary($this->pdo);
    }

    private function render($v, $d = []) {
        $csrf = Session::csrf(); // Generate CSRF token
        if (is_array($d)) extract($d, EXTR_SKIP);
        $flashes = Session::flashes();
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/' . $v . '.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function index() {
        try {
            $semesters = $this->sem->all() ?? [];
            foreach ($semesters as &$semester) {
                if (!empty($semester['cover_image'])) {
                    $semester['cover_url'] = '/image/semester/' . $semester['id'];
                }
            }
            unset($semester);

            // PAKAI TABEL `gallery` (singular)
            $sql = "
                SELECT g.id, g.semester_id, g.caption, s.name AS semester_name
                FROM gallery g
                JOIN semesters s ON g.semester_id = s.id
                WHERE g.image_data IS NOT NULL AND g.image_data <> ''
                ORDER BY g.id DESC
                LIMIT 12
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $recentGallery = $stmt->fetchAll() ?: [];
            foreach ($recentGallery as &$item) {
                $item['image_url'] = url('image/gallery/' . $item['id']);
            }
            unset($item);

            // AMBIL VIDEO DARI GOOGLE DRIVE - REMOVED PER USER REQUEST
            $recentVideos = []; // Video system removed

            // Get Mini Library dari database
            $miniLibraryGroups = $this->miniLib->getAllWithMembers();

            // Hitung total user terdaftar (role user)
            $totalUsers = 0;
            try {
                $stmtUser = $this->pdo->query("SELECT COUNT(*) as total FROM users WHERE role = 'user'");
                $resultUser = $stmtUser->fetch(PDO::FETCH_ASSOC);
                $totalUsers = $resultUser['total'] ?? 0;
            } catch (\Exception $e) {
                $totalUsers = 0;
            }

            $this->render('home/index', compact('semesters', 'recentGallery', 'totalUsers', 'miniLibraryGroups'));
        } catch (\Exception $e) {
            $this->render('home/index', ['semesters' => [], 'recentGallery' => [], 'totalUsers' => 0, 'miniLibraryGroups' => []]);
        }
    }

    public function about() { 
        try {
            // Hitung jumlah mahasiswa aktif (role user)
            $totalStudents = 0;
            try {
                $stmtStudents = $this->pdo->query("SELECT COUNT(*) as total FROM users WHERE role = 'user'");
                $resultStudents = $stmtStudents->fetch(PDO::FETCH_ASSOC);
                $totalStudents = $resultStudents['total'] ?? 0;
            } catch (\Exception $e) {
                $totalStudents = 0;
            }

            // Hitung jumlah mata kuliah dari tabel classes
            $totalSubjects = 0;
            try {
                $stmtSubjects = $this->pdo->query("SELECT COUNT(DISTINCT name) as total FROM classes");
                $resultSubjects = $stmtSubjects->fetch(PDO::FETCH_ASSOC);
                $totalSubjects = $resultSubjects['total'] ?? 0;
            } catch (\Exception $e) {
                $totalSubjects = 0;
            }

            // Hitung jumlah semester yang sudah terdaftar
            $totalSemesters = 0;
            try {
                $stmtSemesters = $this->pdo->query("SELECT COUNT(*) as total FROM semesters");
                $resultSemesters = $stmtSemesters->fetch(PDO::FETCH_ASSOC);
                $totalSemesters = $resultSemesters['total'] ?? 0;
            } catch (\Exception $e) {
                $totalSemesters = 0;
            }

            $this->render('home/about', compact('totalStudents', 'totalSubjects', 'totalSemesters'));
        } catch (\Exception $e) {
            $this->render('home/about', ['totalStudents' => 0, 'totalSubjects' => 0, 'totalSemesters' => 0]);
        }
    }
    public function contact(){ $this->render('home/contact'); }

    public function semesters() {
        $semesters = $this->sem->all() ?? [];
        foreach ($semesters as &$semester) {
            if (!empty($semester['cover_image'])) {
                $semester['cover_url'] = '/image/semester/' . $semester['id'];
            }
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM classes WHERE semester_id = ?");
            $stmt->execute([$semester['id']]);
            $semester['class_count'] = (int)($stmt->fetchColumn() ?? 0);

            // PAKAI TABEL `gallery`
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM gallery WHERE semester_id = ?");
            $stmt->execute([$semester['id']]);
            $semester['gallery_count'] = (int)($stmt->fetchColumn() ?? 0);
        }
        unset($semester);

        $this->render('semester/index', compact('semesters'));
    }

    public function dashboard() {
        if (!Auth::check()) { redirect('login'); }

        $user = Auth::user() ?? [];
        $userRole = $user['role'] ?? 'user';

        if ($userRole === 'user') {
            $semesters = $this->sem->all() ?? [];
            $st = $this->pdo->prepare("
                SELECT c.*, s.name AS semester_name
                FROM classes c
                JOIN semesters s ON c.semester_id = s.id
                WHERE c.pj_user_id = ?
            ");
            $st->execute([ $user['id'] ?? 0 ]);
            $myClasses = $st->fetchAll() ?: [];
            $this->render('user/dashboard', compact('user', 'semesters', 'myClasses'));
        } else {
            redirect('admin');
        }
    }

    public function gallery() {
        try {
            // Ambil semua semester
            $semesters = $this->sem->all() ?? [];

            // Ambil semua gallery dari database
            $allGallery = [];
            try {
                $sql = "
                    SELECT g.id, g.semester_id, g.caption, s.name AS semester_name
                    FROM gallery g
                    JOIN semesters s ON g.semester_id = s.id
                    WHERE g.image_data IS NOT NULL AND g.image_data <> ''
                    ORDER BY g.id DESC
                ";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $allGallery = $stmt->fetchAll() ?: [];

                // Tambahkan URL gambar
                foreach ($allGallery as &$item) {
                    $item['image_url'] = url('image/gallery/' . $item['id']);
                }
                unset($item);
            } catch (\Exception $e) {
                $allGallery = [];
            }

            $this->render('home/gallery_detail', compact('semesters', 'allGallery'));
        } catch (\Exception $e) {
            // Fallback jika ada error
            $this->render('home/gallery_detail', ['semesters' => [], 'allGallery' => []]);
        }
    }
    
    public function privacy() {
        $this->render('home/privacy', ['title' => 'Privacy Policy']);
    }
    
    public function terms() {
        $this->render('home/terms', ['title' => 'Terms of Service']);
    }
    
    public function sitemap() {
        $this->render('home/sitemap', ['title' => 'Sitemap']);
    }
}
