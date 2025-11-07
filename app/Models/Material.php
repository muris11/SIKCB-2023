<?php
namespace App\Models;
use PDO;
class Material {
    public function __construct(private PDO $pdo){}
    public function byClass(int $cid): array { $s=$this->pdo->prepare('SELECT * FROM materials WHERE class_id=? ORDER BY id ASC'); $s->execute([$cid]); return $s->fetchAll(PDO::FETCH_ASSOC); }
    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM materials WHERE id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function save(?int $id, int $classId, string $title, string $type, string $duration, $fileData = null, ?string $fileName = null, ?string $fileType = null, ?string $resourceUrl = null): bool {
        if ($id) {
            if ($fileData) {
                $stmt = $this->pdo->prepare('UPDATE materials SET class_id = ?, title = ?, type = ?, duration = ?, file_data = ?, file_name = ?, file_type = ?, resource_url = ? WHERE id = ?');
                return $stmt->execute([$classId, $title, $type, $duration, $fileData, $fileName, $fileType, $resourceUrl, $id]);
            } else {
                $stmt = $this->pdo->prepare('UPDATE materials SET class_id = ?, title = ?, type = ?, duration = ?, resource_url = ? WHERE id = ?');
                return $stmt->execute([$classId, $title, $type, $duration, $resourceUrl, $id]);
            }
        } else {
            $stmt = $this->pdo->prepare('INSERT INTO materials (class_id, title, type, duration, file_data, file_name, file_type, resource_url, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            return $stmt->execute([$classId, $title, $type, $duration, $fileData, $fileName, $fileType, $resourceUrl, time()]);
        }
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM materials WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
