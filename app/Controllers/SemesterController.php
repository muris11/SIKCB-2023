<?php
namespace App\Controllers;
use App\Core\{Auth, Session};
use App\Models\{Semester, Gallery, Kelas};
use PDO, PDOException;

class SemesterController {
    private PDO $pdo;
    private Semester $sem;
    private Gallery $gal;
    private Kelas $cls;
    
    public function __construct() {
        global $pdo;
        if (!$pdo) {
            // Initialize database connection from config
            $host = DB_HOST;
            $dbname = DB_NAME;
            $username = DB_USER;
            $password = DB_PASS;
            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $GLOBALS['pdo'] = $pdo;
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        $this->pdo = $pdo;
        $this->sem = new Semester($pdo);
        $this->gal = new Gallery($pdo);
        $this->cls = new Kelas($pdo);
    }
    
    private function render($v, $d = []) {
        $csrf = Session::csrf(); // Generate CSRF token
        extract($d);
        $flashes = Session::flashes();
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/' . $v . '.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }
    
    public function index() {
        // Get all semesters with class count and gallery count
        $semesters = $this->pdo->query("
            SELECT s.*, 
                   COUNT(DISTINCT c.id) as class_count,
                   COUNT(DISTINCT g.id) as gallery_count
            FROM semesters s 
            LEFT JOIN classes c ON s.id = c.semester_id 
            LEFT JOIN gallery g ON s.id = g.semester_id 
            GROUP BY s.id 
            ORDER BY s.id DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        $this->render('semester/index', compact('semesters'));
    }

    public function show($id = null) {
        // Get ID from URL parameter, GET parameter, or path
        if ($id === null) {
            $uri = $_SERVER['REQUEST_URI'];
            if (preg_match('/\/semester\/(\d+)/', $uri, $matches)) {
                $id = (int)$matches[1];
            } else {
                $id = (int)($_GET['id'] ?? 0);
            }
        }
        
        // Get semester details
        $semester = $this->sem->find($id);

        if (!$semester) {
            header('HTTP/1.0 404 Not Found');
            $this->render('errors/404');
            return;
        }

        $isLoggedIn = Auth::check();
        
        // Jika tidak login, redirect ke halaman login
        if (!$isLoggedIn) {
            redirect('login?redirect=' . urlencode($_SERVER['REQUEST_URI']));
        }

        $userRole = Auth::user()['role'] ?? '';
        $view = $_GET['view'] ?? 'default';

        // Get classes for this semester (with PJ info if user is logged in)
        $classes = [];
        $classes = $this->pdo->query("
            SELECT c.*, u.name as pj_name 
            FROM classes c 
            LEFT JOIN users u ON c.pj_user_id = u.id 
            WHERE c.semester_id = {$id}
            ORDER BY c.name
        ")->fetchAll(PDO::FETCH_ASSOC);

        // Get gallery for this semester
        $gallery = $this->gal->bySemester($id);
        
        // Add image URL for each gallery item
        foreach ($gallery as &$item) {
            $item['image_url'] = url('image/gallery/' . $item['id']);
        }
        unset($item);
        // Add cover URL if exists
        if (!empty($semester['cover_image'])) {
            $semester['cover_url'] = url('image/semester/' . $semester['id']);
        }

        // Show default view with classes
        $this->render('semester/show', compact('semester', 'classes', 'gallery', 'isLoggedIn'));
    }
    
    public function gallery($id) {
        $id = (int)$id;
        $semester = $this->sem->find($id);
        if (!$semester) {
            header('HTTP/1.0 404 Not Found');
            $this->render('errors/404');
            return;
        }
        
        // Gallery bisa diakses tanpa login
        $gallery = $this->gal->bySemester($id);
        foreach ($gallery as &$img) {
            $img['image_url'] = url('image/gallery/' . $img['id']);
        }
        unset($img);
        $this->render('semester/gallery_detail', compact('semester', 'gallery'));
    }
}
