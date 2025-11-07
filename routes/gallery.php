<?php
if ($_SERVER['REQUEST_URI'] === '/gallery') {
    require_once __DIR__ . '/app/Controllers/HomeController.php';
    $controller = new \App\Controllers\HomeController();
    $controller->gallery();
    exit;
}
?>