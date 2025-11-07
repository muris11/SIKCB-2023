<?php
// Email Configuration with Smart Environment Detection
// This file ensures proper email functionality across environments

// Smart Environment Detection
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$isProduction = (strpos($host, 'sikcb.my.id') !== false || 
                 strpos($host, '.infinityfreeapp.com') !== false || 
                 !empty($_SERVER['HTTP_X_FORWARDED_PROTO']));

// Environment Constants
if (!defined('APP_ENV')) {
    define('APP_ENV', $isProduction ? 'production' : 'development');
}

// Smart APP_URL Detection  
if (!defined('APP_URL')) {
    if ($isProduction) {
        define('APP_URL', 'https://sikcb.my.id');
    } else {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $path = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/');
        if (strpos($_SERVER['REQUEST_URI'] ?? '', '/kelaskita-cms') !== false && 
            strpos($path, '/kelaskita-cms') === false) {
            $path .= '/kelaskita-cms';
        }
        define('APP_URL', $protocol . '://' . $host . $path);
    }
}

// Email Configuration
if (!defined('MAIL_HOST')) {
    define('MAIL_HOST', 'smtp.gmail.com');
    define('MAIL_PORT', 587);
    define('MAIL_USERNAME', 'memories.ofsikc23@gmail.com');
    define('MAIL_PASSWORD', 'owcd ofqz qwnc yign');
    define('MAIL_ENCRYPTION', 'tls');
    define('MAIL_FROM_ADDRESS', 'memories.ofsikc23@gmail.com');
    define('MAIL_FROM_NAME', 'SIKC B 2023');
}

// Log current environment for debugging
error_log("Email Config - Environment: " . APP_ENV . ", URL: " . APP_URL . ", Host: " . $host);