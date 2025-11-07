<?php
namespace App\Controllers;

use App\Models\{Semester, Gallery};
use PDO, PDOException;

class ImageController {
    private PDO $pdo;
    private Semester $sem;
    private Gallery $gal;

    public function __construct() {
        if (!isset($GLOBALS['pdo']) || !$GLOBALS['pdo'] instanceof PDO) {
            $host = DB_HOST;
            $dbname = DB_NAME;
            $username = DB_USER;
            $password = DB_PASS;
            try {
                $pdo = new PDO(
                    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                    $username, $password,
                    [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ]
                );
                $GLOBALS['pdo'] = $pdo;
            } catch (PDOException $e) {
                http_response_code(500);
                exit('Database connection failed: ' . $e->getMessage());
            }
        }
        $this->pdo = $GLOBALS['pdo'];
        $this->sem = new Semester($this->pdo);
        $this->gal = new Gallery($this->pdo);
    }

    private function sendBlob(?string $blob, ?string $mime): void {
        if (empty($blob)) { http_response_code(404); exit; }
        $mime = $mime ?: 'image/jpeg';
        header("Content-Type: {$mime}");
        header("Content-Length: " . strlen($blob));
        header('Cache-Control: public, max-age=31536000, immutable');
        header('ETag: "' . md5($mime . '|' . strlen($blob)) . '"');
        echo $blob; exit;
    }

    // GET /image/semester/{id}
    public function semesterCover($id) {
        $row = $this->sem->getCoverImage((int)$id);
        if (!$row) { http_response_code(404); exit; }
        $blob = $row['cover_image']      ?? null;
        $mime = $row['cover_image_type'] ?? ($row['cover_mime'] ?? null);
        $this->sendBlob($blob, $mime);
    }

    // GET /image/gallery/{id}
    public function galleryImage($id) {
        $row = $this->gal->getImage((int)$id);
        if (!$row) { http_response_code(404); exit; }
        $blob = $row['image_data'] ?? null;
        $mime = $row['image_type'] ?? null;
        $this->sendBlob($blob, $mime);
    }
}
