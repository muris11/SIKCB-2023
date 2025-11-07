<?php
namespace App\Core;
class Session {
    public static function flash(string $type, string $msg): void { $_SESSION['flash'][]=['t'=>$type,'m'=>$msg]; }
    public static function flashes(): array { $f=$_SESSION['flash']??[]; unset($_SESSION['flash']); return $f; }
    public static function csrf(): string { if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(16)); return $_SESSION['csrf']; }
    public static function checkCsrf(?string $t): void { 
        $sessionCsrf = $_SESSION['csrf'] ?? '';
        
        if(!$t || !hash_equals($sessionCsrf, $t)){ 
            http_response_code(400); 
            echo 'Bad Request (CSRF)'; 
            exit; 
        } 
    }
    
    // Additional session methods
    public static function get(string $key, $default = null) { 
        return $_SESSION[$key] ?? $default; 
    }
    
    public static function has(string $key): bool { 
        return isset($_SESSION[$key]); 
    }
    
    public static function token(): string { 
        return self::csrf(); 
    }
}
