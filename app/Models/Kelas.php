<?php
namespace App\Models;
use PDO;
class Kelas {
    public function __construct(private PDO $pdo){}
    public function bySemester(int $sid): array { $s=$this->pdo->prepare('SELECT * FROM classes WHERE semester_id=? ORDER BY id ASC'); $s->execute([$sid]); return $s->fetchAll(PDO::FETCH_ASSOC); }
    public function find(int $id): ?array { $s=$this->pdo->prepare('SELECT c.*, s.name as semester_name, s.term_label FROM classes c JOIN semesters s ON s.id=c.semester_id WHERE c.id=?'); $s->execute([$id]); $r=$s->fetch(PDO::FETCH_ASSOC); return $r?:null; }
    public function save(?int $id,int $sid,string $name,string $status,string $desc,string $teacher,string $schedule,int $sks,string $cover): bool {
        if($id){ $s=$this->pdo->prepare('UPDATE classes SET semester_id=?, name=?, status=?, description=?, teacher=?, schedule=?, sks=?, cover_url=? WHERE id=?'); return $s->execute([$sid,$name,$status,$desc,$teacher,$schedule,$sks,$cover,$id]); }
        $s=$this->pdo->prepare('INSERT INTO classes(semester_id,name,status,description,teacher,schedule,sks,cover_url) VALUES (?,?,?,?,?,?,?,?)'); return $s->execute([$sid,$name,$status,$desc,$teacher,$schedule,$sks,$cover]);
    }
    public function delete(int $id): bool { $s=$this->pdo->prepare('DELETE FROM classes WHERE id=?'); return $s->execute([$id]); }
}
