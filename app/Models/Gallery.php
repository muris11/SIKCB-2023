<?php
namespace App\Models;
use PDO;
class Gallery {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all(): array {
        return $this->pdo->query('SELECT * FROM gallery ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM gallery WHERE id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function bySemester(int $semesterId): array {
        $stmt = $this->pdo->prepare('SELECT * FROM gallery WHERE semester_id = ? ORDER BY id DESC');
        $stmt->execute([$semesterId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(?int $id, int $semesterId, array $imageData, ?string $caption = null): bool {
        if ($id) {
            $stmt = $this->pdo->prepare('UPDATE gallery SET semester_id = ?, image_data = ?, image_type = ?, image_name = ?, caption = ? WHERE id = ?');
            return $stmt->execute([$semesterId, $imageData['data'], $imageData['type'], $imageData['name'], $caption, $id]);
        } else {
            $stmt = $this->pdo->prepare('INSERT INTO gallery (semester_id, image_data, image_type, image_name, caption, created_at) VALUES (?, ?, ?, ?, ?, ?)');
            return $stmt->execute([$semesterId, $imageData['data'], $imageData['type'], $imageData['name'], $caption, time()]);
        }
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM gallery WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function getImage(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT image_data, image_type, image_name FROM gallery WHERE id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}
