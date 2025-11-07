<?php
declare(strict_types=1);

// Handle static files first (favicon, CSS, JS, images)
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedUri = parse_url($requestUri, PHP_URL_PATH);

// Handle favicon requests
if ($parsedUri === '/favicon.ico' || $parsedUri === '/favicon.png' || 
    strpos($parsedUri, '/favicon') !== false) {
    $faviconPath = __DIR__ . '/favicon.ico';
    if (file_exists($faviconPath)) {
        header('Content-Type: image/x-icon');
        header('Cache-Control: public, max-age=86400');
        readfile($faviconPath);
        exit;
    }
}

// Handle other static files
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg)$/', $parsedUri)) {
    $staticFile = __DIR__ . $parsedUri;
    if (file_exists($staticFile)) {
        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript', 
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'ico' => 'image/x-icon',
            'svg' => 'image/svg+xml'
        ];
        $ext = pathinfo($staticFile, PATHINFO_EXTENSION);
        if (isset($mimeTypes[$ext])) {
            header('Content-Type: ' . $mimeTypes[$ext]);
            header('Cache-Control: public, max-age=86400');
        }
        readfile($staticFile);
        exit;
    }
}

// Load config with proper environment detection (prefer production on non-localhost)
$host = strtolower($_SERVER['HTTP_HOST'] ?? '');
$isLocal = $host === 'localhost' || $host === '127.0.0.1' || preg_match('/^localhost:\\d+$/', $host);
$prodConfig = __DIR__ . '/../app/Config/config_production.php';
$devConfig  = __DIR__ . '/../app/Config/config.php';

$configLoaded = false;
if (!$isLocal && is_file($prodConfig)) {
    require $prodConfig;
    $configLoaded = true;
} elseif (is_file($devConfig)) {
    require $devConfig;
    $configLoaded = true;
} elseif (is_file($prodConfig)) {
    require $prodConfig;
    $configLoaded = true;
}

if (!$configLoaded) {
    die("FATAL: Config file not found in public/index.php");
}

// Secure session cookie flags + start session
if (session_status() === PHP_SESSION_NONE) {
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    @session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => $_SERVER['HTTP_HOST'] ?? '',
        'secure'   => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

require __DIR__ . '/../app/Core/Session.php';
require __DIR__ . '/../app/Core/Auth.php';
require __DIR__ . '/../app/Core/Router.php';

// Models
require __DIR__ . '/../app/Models/User.php';
require __DIR__ . '/../app/Models/Semester.php';
require __DIR__ . '/../app/Models/Kelas.php';
require __DIR__ . '/../app/Models/Gallery.php';

// Controllers
require __DIR__ . '/../app/Controllers/AuthController.php';
require __DIR__ . '/../app/Controllers/HomeController.php';
require __DIR__ . '/../app/Controllers/SemesterController.php';
require __DIR__ . '/../app/Controllers/KelasController.php';
require __DIR__ . '/../app/Controllers/AdminController.php';
require __DIR__ . '/../app/Controllers/ImageController.php';

use App\Core\Router;

$router = new Router();

// (opsional) kalau Router mendukung base path:
// if (method_exists($router, 'setBasePath')) {
//   $router->setBasePath(rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\'));
// }

// ROUTES (punyamu)
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
$router->get('/test-email', [App\Controllers\AuthController::class, 'testEmail']);

$router->get('/dashboard', [App\Controllers\HomeController::class, 'dashboard']);
$router->get('/about', [App\Controllers\HomeController::class, 'about']);
$router->get('/contact', [App\Controllers\HomeController::class, 'contact']);

$router->get('/admin', [App\Controllers\AdminController::class, 'index']);
$router->get('/admin/users', [App\Controllers\AdminController::class, 'users']);
$router->post('/admin/users/role', [App\Controllers\AdminController::class, 'userRole']);
$router->post('/admin/users/delete', [App\Controllers\AdminController::class, 'userDelete']);
$router->post('/admin/user/edit', [App\Controllers\AdminController::class, 'userEdit']);

$router->get('/admin/semesters', [App\Controllers\AdminController::class, 'semesters']);
$router->post('/admin/semesters', [App\Controllers\AdminController::class, 'semesterSave']);
$router->post('/admin/semester/delete', [App\Controllers\AdminController::class, 'semesterDelete']);
$router->post('/admin/semester/save', [App\Controllers\AdminController::class, 'semesterSave']);

$router->get('/admin/classes', [App\Controllers\AdminController::class, 'classes']);
$router->post('/admin/classes', [App\Controllers\AdminController::class, 'classSave']);
$router->post('/admin/class/delete', [App\Controllers\AdminController::class, 'classDelete']);

$router->get('/admin/gallery', [App\Controllers\AdminController::class, 'gallery']);
$router->post('/admin/gallery', [App\Controllers\AdminController::class, 'gallerySave']);
$router->post('/admin/gallery/save', [App\Controllers\AdminController::class, 'gallerySave']);
$router->post('/admin/gallery/delete', [App\Controllers\AdminController::class, 'galleryDelete']);

$router->get('/image/semester/{id}', [App\Controllers\ImageController::class, 'semesterCover']);
$router->get('/image/gallery/{id}', [App\Controllers\ImageController::class, 'galleryImage']);

try {
  $router->dispatch();
} catch (Exception $e) {
  header('HTTP/1.0 404 Not Found');
  include __DIR__ . '/../app/Views/errors/404.php';
}
