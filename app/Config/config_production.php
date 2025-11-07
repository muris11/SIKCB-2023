<?php
declare(strict_types=1);

// Sembunyikan error di produksi
error_reporting(0);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// BASE_URL otomatis
$https  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$scheme = $https ? 'https://' : 'http://';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
$dir    = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
$base   = ($dir === '.' || $dir === '/') ? '' : $dir;
define('BASE_URL', $scheme.$host.$base.'/');

// Helper URL
if (!function_exists('url'))      { function url($p=''){ return BASE_URL.ltrim($p,'/'); } }
if (!function_exists('asset'))    { function asset($p=''){ return BASE_URL.'assets/'.ltrim($p,'/'); } }
if (!function_exists('redirect')) { function redirect($p=''){ header('Location: '.url($p)); exit; } }

const APP_NAME = 'SIKC B 2023';
const DEVELOPMENT_MODE = false; // Production mode

// ⚠️ UPDATE DENGAN DATA DATABASE INFINITYFREE KAMU!
// Cari di cPanel > MySQL Databases > Database Details
const DB_HOST    = 'localhost';
const DB_NAME    = 'rifqysaputramy_sikcb';
const DB_USER    = 'rifqysaputramy_app';
const DB_PASS    = '@sikcb2023'; // ganti dengan password asli
const DB_CHARSET = 'utf8mb4';


// Database helper with InfinityFree optimizations
if (!function_exists('db')) {
  function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    
  // InfinityFree: pakai port 3306 secara eksplisit
  $dsn = 'mysql:host='.DB_HOST.';port=3306;dbname='.DB_NAME.';charset='.DB_CHARSET;
    
    $opt = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
      PDO::ATTR_PERSISTENT         => false, // InfinityFree doesn't support persistent connections
      PDO::ATTR_TIMEOUT            => 30,    // Connection timeout for shared hosting
    ];
    
    try {
      return $pdo = new PDO($dsn, DB_USER, DB_PASS, $opt);
    } catch (PDOException $e) {
      // Log error for debugging (without exposing credentials)
      error_log("Database connection failed: " . $e->getMessage());
      throw new Exception("Database connection failed. Check your database credentials in config_production.php");
    }
  }
}
