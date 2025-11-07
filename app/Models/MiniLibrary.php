<?php
namespace App\Models;
use PDO;

class MiniLibrary {
    public $lastError = '';

    public function __construct(private PDO $pdo) {}

    /**
     * Get all mini library groups
     */
    public function all(): array {
        $stmt = $this->pdo->prepare('SELECT * FROM mini_library ORDER BY created_at DESC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get mini library by ID
     */
    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM mini_library WHERE id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Get members of a group
     */
    public function getMembers(int $libraryId): array {
        $stmt = $this->pdo->prepare('SELECT * FROM mini_library_members WHERE mini_library_id = ? ORDER BY name ASC');
        $stmt->execute([$libraryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create new mini library group
     */
    public function create(
        string $groupName,
        string $description,
        string $category,
        string $link, // tetap ada untuk kompatibilitas controller, tapi tidak dipakai
        string $image,
        array $members
    ): bool {
        try {
            $this->pdo->beginTransaction();

            // Insert main record (tanpa kolom link)
            $stmt = $this->pdo->prepare('
                INSERT INTO mini_library (group_name, description, category, link, image, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, NOW(), NOW())
            ');
            
            $stmt->execute([$groupName, $description, $category, $link, $image]);
            $libraryId = $this->pdo->lastInsertId();

            // Insert members
            $memberStmt = $this->pdo->prepare('
                INSERT INTO mini_library_members (mini_library_id, name)
                VALUES (?, ?)
            ');

            foreach ($members as $member) {
                $memberStmt->execute([$libraryId, $member]);
            }

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            $this->lastError = $e->getMessage();
            error_log('MiniLibrary create error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update mini library group
     */
    public function update(
        int $id,
        string $groupName,
        string $description,
        string $category,
        string $link, // tetap ada untuk kompatibilitas controller, tapi tidak dipakai
        string $image,
        array $members
    ): bool {
        try {
            $this->pdo->beginTransaction();

            // Update main record (tanpa kolom link)
            $stmt = $this->pdo->prepare('
                UPDATE mini_library SET group_name=?, description=?, category=?, link=?, image=?, updated_at=NOW() WHERE id=?
            ');
            
            $stmt->execute([$groupName, $description, $category, $link, $image, $id]);

            // Hapus anggota lama
            $this->pdo->prepare('DELETE FROM mini_library_members WHERE mini_library_id=?')->execute([$id]);

            // Insert anggota baru
            $memberStmt = $this->pdo->prepare('
                INSERT INTO mini_library_members (mini_library_id, name)
                VALUES (?, ?)
            ');

            foreach ($members as $member) {
                $memberStmt->execute([$id, $member]);
            }

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            $this->lastError = $e->getMessage();
            error_log('MiniLibrary update error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete mini library group (with cascade)
     */
    public function delete(int $id): bool {
        try {
            $this->pdo->beginTransaction();

            // Delete members
            $memberStmt = $this->pdo->prepare('DELETE FROM mini_library_members WHERE mini_library_id = ?');
            $memberStmt->execute([$id]);

            // Delete main record
            $stmt = $this->pdo->prepare('DELETE FROM mini_library WHERE id = ?');
            $result = $stmt->execute([$id]);

            $this->pdo->commit();
            return $result;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            error_log('MiniLibrary delete error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get library with members (joined)
     */
    public function getAllWithMembers(): array {
        $libraries = $this->all();
        foreach ($libraries as &$library) {
            $library['members'] = $this->getMembers($library['id']);
        }
        return $libraries;
    }
}
