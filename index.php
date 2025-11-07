<?php
declare(strict_types=1);

// ==== ENV DETECT ====
$host = strtolower($_SERVER['HTTP_HOST'] ?? '');
$isLocal = $host === 'localhost' || $host === '127.0.0.1' || preg_match('/^localhost:\d+$/', $host);

// ==== ERROR REPORTING ====
error_reporting($isLocal ? E_ALL : 0);
ini_set('display_errors', $isLocal ? '1' : '0');

if (session_status() === PHP_SESSION_NONE) session_start();
// Harden session cookies in all environments
if (session_status() === PHP_SESSION_ACTIVE) {
  $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
  @session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => $_SERVER['HTTP_HOST'] ?? '',
    'secure'   => $secure,
    'httponly' => true,
    'samesite' => 'Lax',
  ]);
}

// ==== ABSOLUTE PROJECT ROOT (folder yang berisi /app) ====
$ROOT = __DIR__;

/** helper: require kandidat pertama yang ada */
function require_first_existing(array $candidates, string $label): void {
  foreach ($candidates as $p) {
    if (is_file($p)) { require_once $p; return; }
  }
  http_response_code(500);
  header('Content-Type: text/plain; charset=utf-8');
  echo "FATAL: File {$label} tidak ditemukan.\nDicari di:\n- ".implode("\n- ", $candidates)."\n";
  exit;
}

// (opsional) composer autoload (kalau ada)
$autoload = $ROOT . '/vendor/autoload.php';
if (is_file($autoload)) require_once $autoload;

// ==== LOAD CONFIG SESUAI ENV ====
// Prioritaskan config_production.php saat bukan localhost
$prodCandidates = [
  $ROOT . '/app/Config/config_production.php',
  __DIR__ . '/app/Config/config_production.php'
];
$devCandidates = [
  $ROOT . '/app/Config/config.php',
  __DIR__ . '/app/Config/config.php'
];

$configLoaded = false;
$configUsed = '';

if (!$isLocal) {
  foreach ($prodCandidates as $p) { if (is_file($p)) { require_once $p; $configLoaded = true; $configUsed = $p; break; } }
}
if (!$configLoaded) {
  foreach ($devCandidates as $p) { if (is_file($p)) { require_once $p; $configLoaded = true; $configUsed = $p; break; } }
}

if (!$configLoaded) {
    // Debug info untuk troubleshooting
    $debug = "FATAL: Config file tidak ditemukan!\n\n";
    $debug .= "Environment Detection:\n";
    $debug .= "- Host: " . ($_SERVER['HTTP_HOST'] ?? 'unknown') . "\n";
    $debug .= "- Is Local: " . ($isLocal ? 'YES' : 'NO') . "\n\n";
    $debug .= "Path Info:\n";
    $debug .= "- __DIR__: " . __DIR__ . "\n";
    $debug .= "- ROOT: " . $ROOT . "\n\n";
    $debug .= "Paths dicari:\n";
    foreach ($configPaths as $path) {
        $debug .= "- " . $path . " (" . (is_file($path) ? 'FOUND' : 'NOT FOUND') . ")\n";
    }
    $debug .= "\nFiles di app/Config:\n";
    $configDir = $ROOT . '/app/Config';
    if (is_dir($configDir)) {
        $files = scandir($configDir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $debug .= "- " . $file . "\n";
            }
        }
    } else {
        $debug .= "- Directory tidak ditemukan: " . $configDir . "\n";
    }
    
    die($debug);
}


// ==== CORE ====
require_first_existing([$ROOT.'/app/Core/Session.php'],   'app/Core/Session.php');
require_first_existing([$ROOT.'/app/Core/Auth.php'],      'app/Core/Auth.php');
require_first_existing([$ROOT.'/app/Core/Router.php'],    'app/Core/Router.php');

// Mailer (dibutuhkan utk forgot password). Jika kamu punya App\Core\Mailer, require di sini:
if (is_file($ROOT.'/app/Core/Mailer.php')) {
  require_once $ROOT.'/app/Core/Mailer.php';
}

// ==== MODELS ====
require_first_existing([$ROOT.'/app/Models/User.php'],     'app/Models/User.php');
require_first_existing([$ROOT.'/app/Models/Semester.php'], 'app/Models/Semester.php');
require_first_existing([$ROOT.'/app/Models/Kelas.php'],    'app/Models/Kelas.php');
require_first_existing([$ROOT.'/app/Models/Gallery.php'],  'app/Models/Gallery.php');
require_first_existing([$ROOT.'/app/Models/MiniLibrary.php'], 'app/Models/MiniLibrary.php');

// ==== CONTROLLERS ====
require_first_existing([$ROOT.'/app/Controllers/AuthController.php'],     'app/Controllers/AuthController.php');
require_first_existing([$ROOT.'/app/Controllers/HomeController.php'],     'app/Controllers/HomeController.php');
require_first_existing([$ROOT.'/app/Controllers/SemesterController.php'], 'app/Controllers/SemesterController.php');
require_first_existing([$ROOT.'/app/Controllers/KelasController.php'],    'app/Controllers/KelasController.php');
require_first_existing([$ROOT.'/app/Controllers/AdminController.php'],    'app/Controllers/AdminController.php');
require_first_existing([$ROOT.'/app/Controllers/ImageController.php'],    'app/Controllers/ImageController.php');

use App\Core\Router;

// ==== ROUTER INIT ====
$router = new App\Core\Router();

// Base path untuk subfolder (localhost pakai http://localhost/kelaskita-cms/ → basePath=/kelaskita-cms)
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$basePath   = rtrim(str_replace('\\','/', dirname($scriptName)), '/');
if ($basePath === '.' || $basePath === '/') $basePath = '';
if (method_exists($router, 'setBasePath')) $router->setBasePath($basePath);

// ==== ROUTES ====
$router->get('/', [App\Controllers\HomeController::class, 'index']);
$router->get('/semesters', [App\Controllers\SemesterController::class, 'index']);
$router->get('/semester', [App\Controllers\SemesterController::class, 'show']);
$router->get('/semester/{id}', [App\Controllers\SemesterController::class, 'show']);
$router->get('/semester/{id}/gallery', [App\Controllers\SemesterController::class, 'gallery']);
$router->get('/kelas', [App\Controllers\KelasController::class, 'show']);
$router->get('/kelas/{id}', [App\Controllers\KelasController::class, 'show']);
$router->get('/gallery', [App\Controllers\HomeController::class, 'gallery']);

$router->get('/login', [App\Controllers\AuthController::class, 'loginForm']);
$router->post('/login', [App\Controllers\AuthController::class, 'login']);
$router->get('/register', [App\Controllers\AuthController::class, 'registerForm']);
$router->post('/register', [App\Controllers\AuthController::class, 'register']);
$router->get('/logout', [App\Controllers\AuthController::class, 'logout']);

$router->get('/password/forgot', [App\Controllers\AuthController::class, 'forgotPassword']);
$router->post('/password/forgot', [App\Controllers\AuthController::class, 'forgotPassword']);
$router->get('/password/reset', [App\Controllers\AuthController::class, 'resetPassword']);
$router->post('/password/reset', [App\Controllers\AuthController::class, 'resetPassword']);

$router->get('/dashboard', [App\Controllers\HomeController::class, 'dashboard']);
$router->get('/about', [App\Controllers\HomeController::class, 'about']);
$router->get('/contact', [App\Controllers\HomeController::class, 'contact']);
$router->get('/privacy', [App\Controllers\HomeController::class, 'privacy']);
$router->get('/terms', [App\Controllers\HomeController::class, 'terms']);
$router->get('/sitemap', [App\Controllers\HomeController::class, 'sitemap']);

$router->get('/admin', [App\Controllers\AdminController::class, 'index']);
$router->get('/admin/users', [App\Controllers\AdminController::class, 'users']);
$router->post('/admin/users/role', [App\Controllers\AdminController::class, 'changeRole']);
$router->post('/admin/users/delete', [App\Controllers\AdminController::class, 'deleteUser']);
$router->post('/admin/user/edit', [App\Controllers\AdminController::class, 'userEdit']);
$router->post('/admin/user/add', [App\Controllers\AdminController::class, 'userAdd']);

$router->get('/admin/semesters', [App\Controllers\AdminController::class, 'semesters']);
$router->post('/admin/semesters', [App\Controllers\AdminController::class, 'semesterSave']);
$router->post('/admin/semester/delete', [App\Controllers\AdminController::class, 'semesterDelete']);
$router->post('/admin/semester/save', [App\Controllers\AdminController::class, 'semesterSave']);

$router->get('/admin/classes', [App\Controllers\AdminController::class, 'classes']);
$router->post('/admin/classes', [App\Controllers\AdminController::class, 'classSave']);
$router->post('/admin/class/delete', [App\Controllers\AdminController::class, 'classDelete']);

$router->get('/admin/gallery', [App\Controllers\AdminController::class, 'gallery']);
$router->post('/admin/gallery', [App\Controllers\AdminController::class, 'gallery']);
$router->post('/admin/gallery/save', [App\Controllers\AdminController::class, 'gallery']);
$router->post('/admin/gallery/delete', [App\Controllers\AdminController::class, 'galleryDelete']);

$router->get('/admin/mini_library', [App\Controllers\AdminController::class, 'miniLibrary']);
$router->post('/admin/mini_library/save', [App\Controllers\AdminController::class, 'miniLibrarySave']);
$router->post('/admin/mini_library/update', [App\Controllers\AdminController::class, 'miniLibrarySave']);
$router->post('/admin/mini_library/delete', [App\Controllers\AdminController::class, 'miniLibraryDelete']);

$router->get('/image/semester/{id}', [App\Controllers\ImageController::class, 'semesterCover']);
$router->get('/image/gallery/{id}', [App\Controllers\ImageController::class, 'galleryImage']);

// ==== DISPATCH ====
try {
  $router->dispatch();
} catch (Throwable $e) {
  error_log('Router error: '.$e->getMessage());
  http_response_code(404);
  $errView = $ROOT . '/app/Views/errors/404.php';
  if (is_file($errView)) include $errView;
  else { header('Content-Type:text/plain; charset=utf-8'); echo "404 Not Found\n\n".$e->getMessage(); }
}









