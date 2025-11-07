<?php
namespace App\Models;
use PDO;
class Semester {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all(): array {
        return $this->pdo->query('SELECT * FROM semesters ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM semesters WHERE id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function save(?int $id, string $name, string $termLabel, string $description, ?array $coverImageData = null): bool {
        if ($id) {
            if ($coverImageData) {
                $stmt = $this->pdo->prepare('UPDATE semesters SET name = ?, term_label = ?, description = ?, cover_image = ?, cover_image_type = ? WHERE id = ?');
                return $stmt->execute([$name, $termLabel, $description, $coverImageData['data'], $coverImageData['type'], $id]);
            } else {
                $stmt = $this->pdo->prepare('UPDATE semesters SET name = ?, term_label = ?, description = ? WHERE id = ?');
                return $stmt->execute([$name, $termLabel, $description, $id]);
            }
        } else {
            $stmt = $this->pdo->prepare('INSERT INTO semesters (name, term_label, description, cover_image, cover_image_type, created_at) VALUES (?, ?, ?, ?, ?, ?)');
            return $stmt->execute([$name, $termLabel, $description, $coverImageData['data'] ?? null, $coverImageData['type'] ?? null, time()]);
        }
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM semesters WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function getCoverImage(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT cover_image, cover_image_type FROM semesters WHERE id = ? AND cover_image IS NOT NULL');
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}
