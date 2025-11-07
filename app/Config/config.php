<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

$https  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$scheme = $https ? 'https://' : 'http://';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
$dir    = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
$base   = ($dir === '.' || $dir === '/') ? '' : $dir;
define('BASE_URL', $scheme.$host.$base.'/');

if (!function_exists('url'))      { function url($p=''){ return BASE_URL.ltrim($p,'/'); } }
if (!function_exists('asset'))    { function asset($p=''){ return BASE_URL.'assets/'.ltrim($p,'/'); } }
if (!function_exists('redirect')) { function redirect($p=''){ header('Location: '.url($p)); exit; } }

const APP_NAME = 'SIKC B 2023';
const DEVELOPMENT_MODE = true; // Set to false in production

// DB lokal
const DB_HOST    = 'localhost';
const DB_NAME    = 'kelaskita_cms';
const DB_USER    = 'root';
const DB_PASS    = '';
const DB_CHARSET = 'utf8mb4';