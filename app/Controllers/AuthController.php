<?php
namespace App\Controllers;
use App\Core\Session;
use App\Models\User;
use PDO, PDOException;

class AuthController {
    private PDO $pdo; private User $users;
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
        $this->users = new User($pdo);
    }
    private function render($view,$data=[]){ 
        $csrf = Session::csrf(); // Generate CSRF token
        extract($data); 
        $flashes=Session::flashes(); 
        include __DIR__.'/../Views/layout/header.php'; 
        include __DIR__.'/../Views/'.$view.'.php'; 
        include __DIR__.'/../Views/layout/footer.php'; 
    }
    public function loginForm(){ $this->render('auth/login'); }
    public function registerForm(){ $this->render('auth/register'); }
    public function forgotForm(){ $this->render('auth/forgot'); }
    public function resetForm(){ $token=$_GET['token']??''; $this->render('auth/reset', compact('token')); }

    public function register(){
        Session::checkCsrf($_POST['_csrf']??null);
        $name=trim($_POST['name']??''); $email=strtolower(trim($_POST['email']??'')); $pass=$_POST['password']??''; $pass2=$_POST['password2']??'';
        
        // Validasi input
        if (empty($name)) {
            Session::flash('error', 'Nama lengkap harus diisi.');
            redirect('register');
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', 'Email tidak valid. Silakan masukkan email yang benar.');
            redirect('register');
        }
        if (empty($pass)) {
            Session::flash('error', 'Password harus diisi.');
            redirect('register');
        }
        if (strlen($pass) < 6) {
            Session::flash('error', 'Password minimal 6 karakter.');
            redirect('register');
        }
        if ($pass !== $pass2) {
            Session::flash('error', 'Konfirmasi password tidak cocok.');
            redirect('register');
        }
        
        // Cek email sudah terdaftar
        if ($this->users->findByEmail($email)) {
            Session::flash('error', 'Email sudah terdaftar. Silakan gunakan email lain atau login.');
            redirect('register');
        }
        
        // Buat akun baru
        $ok = $this->users->create($name, $email, password_hash($pass, PASSWORD_DEFAULT));
        if ($ok) {
            Session::flash('success', 'Selamat! Registrasi berhasil. Silakan login dengan akun Anda.');
            redirect('login');
        }
        
        Session::flash('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        redirect('register');
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check CSRF token
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Validasi input
            if (empty($email)) {
                \App\Core\Session::flash('error', 'Email harus diisi.');
                $this->render('auth/login');
                return;
            }
            if (empty($password)) {
                \App\Core\Session::flash('error', 'Password harus diisi.');
                $this->render('auth/login');
                return;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                \App\Core\Session::flash('error', 'Format email tidak valid.');
                $this->render('auth/login');
                return;
            }
            
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];
                
                \App\Core\Session::flash('success', 'Selamat datang, ' . htmlspecialchars($user['name']) . '!');
                
                // Redirect sesuai role
                if ($user['role'] === 'admin') {
                    redirect('admin');
                } else {
                    redirect('dashboard');
                }
                exit;
            } else {
                \App\Core\Session::flash('error', 'Email atau password yang Anda masukkan salah. Silakan periksa kembali.');
            }
        }
        $this->render('auth/login');
    }
    public function logout() {
        $userName = $_SESSION['user']['name'] ?? 'User';
        session_destroy();
        session_start();
        Session::flash('success', 'Sampai jumpa, ' . htmlspecialchars($userName) . '! Anda telah berhasil logout.');
        redirect('');
    }
    public function requestReset(){
        // Check CSRF token
        Session::checkCsrf($_POST['_csrf'] ?? null);
        
        $email = strtolower(trim($_POST['email'] ?? ''));
        
        if (empty($email)) {
            Session::flash('error', 'Email harus diisi.');
            redirect('password/forgot');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', 'Format email tidak valid.');
            redirect('password/forgot');
        }
        
        $u = $this->users->findByEmail($email);
        if ($u) {
            try {
                $t = bin2hex(random_bytes(32));
                $exp = time() + 3600;
                $this->users->setReset((int)$u['id'], $t, $exp);
                
                // Send real email
                $mailer = new \App\Core\Mailer();
                $emailSent = $mailer->sendPasswordReset($u['email'], $u['name'], $t);
                
                if ($emailSent) {
                    Session::flash('success', 'Email reset password telah dikirim ke ' . htmlspecialchars($u['email']) . '. Silakan cek inbox atau folder spam Anda.');
                } else {
                    Session::flash('error', 'Terjadi masalah saat mengirim email. Silakan coba lagi beberapa saat.');
                }
            } catch (\Exception $e) {
                error_log("Email sending error: " . $e->getMessage());
                Session::flash('error', 'Terjadi kesalahan saat mengirim email reset. Silakan coba lagi.');
            }
        } else {
            Session::flash('info', 'Jika email terdaftar di sistem, link reset password akan dikirimkan.');
        }
        redirect('password/forgot');
    }
    public function resetPassword() {
        $token = $_GET['token'] ?? $_POST['token'] ?? '';
        if (!$token) {
            \App\Core\Session::flash('error', 'Token reset password tidak ditemukan. Silakan ajukan reset password baru.');
            redirect('password/forgot');
        }
        
        // Cek token di database
        $stmt = $this->pdo->prepare('SELECT * FROM password_resets WHERE token = ? AND expires_at > ?');
        $stmt->execute([$token, time()]);
        $reset = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$reset) {
            \App\Core\Session::flash('error', 'Token reset password tidak valid atau sudah kadaluarsa. Silakan ajukan reset password baru.');
            redirect('password/forgot');
        }
        
        $error = $success = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check CSRF token
            \App\Core\Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $password = $_POST['password'] ?? '';
            $password2 = $_POST['password2'] ?? '';
            
            if (empty($password)) {
                $error = 'Password baru harus diisi.';
            } elseif (strlen($password) < 6) {
                $error = 'Password minimal 6 karakter.';
            } elseif (empty($password2)) {
                $error = 'Konfirmasi password harus diisi.';
            } elseif ($password !== $password2) {
                $error = 'Konfirmasi password tidak cocok. Silakan periksa kembali.';
            } else {
                try {
                    // Update password user
                    $stmt = $this->pdo->prepare('UPDATE users SET password_hash = ? WHERE email = ?');
                    $stmt->execute([password_hash($password, PASSWORD_BCRYPT), $reset['email']]);
                    
                    // Hapus token
                    $stmt = $this->pdo->prepare('DELETE FROM password_resets WHERE email = ?');
                    $stmt->execute([$reset['email']]);
                    
                    \App\Core\Session::flash('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
                    redirect('login');
                    return;
                } catch (\Exception $e) {
                    $error = 'Terjadi kesalahan saat mereset password. Silakan coba lagi.';
                }
            }
            $this->render('auth/reset', compact('error', 'token'));
            return;
        }
        $this->render('auth/reset', compact('token'));
    }
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check CSRF token
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $email = trim($_POST['email'] ?? '');
            
            if (empty($email)) {
                Session::flash('error', 'Email harus diisi.');
                $this->render('auth/forgot');
                return;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Session::flash('error', 'Format email tidak valid.');
                $this->render('auth/forgot');
                return;
            }
            
            // Check if user exists
            $stmt = $this->pdo->prepare('SELECT id, email, name FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                try {
                    // Generate reset token
                    $token = bin2hex(random_bytes(32));
                    $expiresAt = time() + 3600; // 1 hour
                    
                    // Delete existing tokens for this email
                    $stmt = $this->pdo->prepare('DELETE FROM password_resets WHERE email = ?');
                    $stmt->execute([$email]);
                    
                    // Store new token in database
                    $stmt = $this->pdo->prepare('INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)');
                    $stmt->execute([$email, $token, $expiresAt]);
                    
                    // Send actual email using our Mailer service
                    $mailer = new \App\Core\Mailer();
                    $emailSent = $mailer->sendPasswordReset($user['email'], $user['name'], $token);
                    
                    if ($emailSent) {
                        Session::flash('success', 'Email reset password telah dikirim ke ' . htmlspecialchars($user['email']) . '. Silakan cek inbox atau folder spam Anda.');
                    } else {
                        Session::flash('error', 'Terjadi masalah saat mengirim email. Silakan coba lagi beberapa saat.');
                    }
                    
                    $this->render('auth/forgot');
                    return;
                } catch (\Exception $e) {
                    error_log("Password reset error: " . $e->getMessage());
                    Session::flash('error', 'Terjadi kesalahan saat memproses permintaan reset password. Silakan coba lagi.');
                    $this->render('auth/forgot');
                    return;
                }
            } else {
                // For security, don't reveal if email exists or not
                Session::flash('info', 'Jika email tersebut terdaftar di sistem, kami telah mengirimkan link reset password. Silakan cek inbox atau folder spam Anda.');
                $this->render('auth/forgot');
                return;
            }
        }
        
        // Show form
        $this->render('auth/forgot');
    }
    
    // Test email functionality (only for development)
    public function testEmail() {
        if (!isset($_GET['test']) || $_GET['test'] !== 'email') {
            die('Not allowed');
        }
        
        try {
            $mailer = new \App\Core\Mailer();
            
            // Test SMTP connection
            echo "<h3>Testing SMTP Connection...</h3>";
            $connectionTest = $mailer->testConnection();
            echo $connectionTest ? "✅ SMTP Connection: SUCCESS<br>" : "❌ SMTP Connection: FAILED<br>";
            
            // Test actual email sending
            echo "<h3>Testing Email Sending...</h3>";
            $testEmail = 'test@example.com'; // Change this to your test email
            $emailSent = $mailer->sendPasswordReset($testEmail, 'Test User', 'test-token-123');
            echo $emailSent ? "✅ Email Sending: SUCCESS<br>" : "❌ Email Sending: FAILED<br>";
            
            echo "<br><p>Check the logs for detailed error messages if any test failed.</p>";
            
        } catch (\Exception $e) {
            echo "❌ Error: " . htmlspecialchars($e->getMessage());
        }
    }
}
