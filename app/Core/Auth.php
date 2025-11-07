<?php
namespace App\Core;
class Auth {
    public static function user(): ?array { return $_SESSION['auth'] ?? null; }
    public static function check(): bool {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    public static function isAdmin(): bool {
        return self::check() && ($_SESSION['role'] ?? '') === 'admin';
    }
    public static function requireAuth(): void {
        if (!self::check()) {
            header('Location: /login');
            exit;
        }
    }
    public static function requireAdmin(): void { if(!self::isAdmin()){ header('Location: /dashboard'); exit; } }
    public static function requireRole(string $role): void {
        self::requireAuth();
        $user = self::user();
        if (!$user || $user['role'] !== $role) {
            header('Location: /login');
            exit;
        }
    }
}
