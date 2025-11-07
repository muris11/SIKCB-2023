<?php
namespace App\Controllers;
use App\Core\{Auth, Session};
use PDO;
class DashboardController {
    private PDO $pdo;
    public function __construct(){ global $pdo; $this->pdo=$pdo; }
    private function render($v,$d=[]){ 
        $csrf = Session::csrf(); // Generate CSRF token
        extract($d); 
        $flashes=Session::flashes(); 
        include __DIR__.'/../Views/layout/header.php'; 
        include __DIR__.'/../Views/'.$v.'.php'; 
        include __DIR__.'/../Views/layout/footer.php'; 
    }
    public function index(){
        Auth::requireAuth();
        $classes = $this->pdo->query("SELECT c.name, c.teacher, c.id FROM classes c ORDER BY c.id ASC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
        $this->render('dashboard/index', compact('classes'));
    }
}
