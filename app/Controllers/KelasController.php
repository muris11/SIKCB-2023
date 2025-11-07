<?php
namespace App\Controllers;
use App\Core\{Auth, Session};
use App\Models\{Kelas, Semester};
use PDO, PDOException;

class KelasController {
    private PDO $pdo;
    private Kelas $cls;
    private Semester $sem;
    
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
        $this->cls = new Kelas($pdo);
        $this->sem = new Semester($pdo);
    }
    
    private function render($v, $d = []) {
        $csrf = Session::csrf(); // Generate CSRF token
        extract($d);
        $flashes = Session::flashes();
        include __DIR__ . '/../Views/layout/header.php';
        include __DIR__ . '/../Views/' . $v . '.php';
        include __DIR__ . '/../Views/layout/footer.php';
    }

    public function show($id = null) {
        if (!Auth::check()) {
            redirect('login');
        }
        
        // Get ID from URL parameter or default
        if ($id === null) {
            $id = (int)($_GET['id'] ?? 0);
        }
        
        $class = $this->cls->find($id);
        
        if (!$class) {
            header('HTTP/1.0 404 Not Found');
            $this->render('errors/404');
            return;
        }
        
        $semester = $this->sem->find($class['semester_id']);
        
        $this->render('kelas/show', compact('class', 'semester'));
    }
}
