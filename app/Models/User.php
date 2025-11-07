<?php
namespace App\Models;
use PDO;
class User {
    public function __construct(private PDO $pdo){}
    public function findByEmail(string $email): ?array { $s=$this->pdo->prepare('SELECT * FROM users WHERE email=?'); $s->execute([$email]); $u=$s->fetch(PDO::FETCH_ASSOC); return $u?:null; }
    public function findByToken(string $t): ?array { $s=$this->pdo->prepare('SELECT * FROM users WHERE reset_token=?'); $s->execute([$t]); $u=$s->fetch(PDO::FETCH_ASSOC); return $u?:null; }
    public function create(string $name,string $email,string $hash): bool { $s=$this->pdo->prepare('INSERT INTO users (name,email,password_hash,role,created_at) VALUES (?,?,?,?,?)'); return $s->execute([$name,$email,$hash,'user',time()]); }
    public function createWithRole(string $name,string $email,string $hash,string $role): bool { $s=$this->pdo->prepare('INSERT INTO users (name,email,password_hash,role,created_at) VALUES (?,?,?,?,?)'); return $s->execute([$name,$email,$hash,$role,time()]); }
    public function setReset(int $id,string $token,int $exp): bool { $s=$this->pdo->prepare('UPDATE users SET reset_token=?, reset_expires=? WHERE id=?'); return $s->execute([$token,$exp,$id]); }
    public function updatePass(int $id,string $hash): bool { $s=$this->pdo->prepare('UPDATE users SET password_hash=?, reset_token=NULL, reset_expires=NULL WHERE id=?'); return $s->execute([$hash,$id]); }
    public function all(int $limit=100,int $offset=0): array { $s=$this->pdo->prepare('SELECT * FROM users ORDER BY id DESC LIMIT ? OFFSET ?'); $s->execute([$limit,$offset]); return $s->fetchAll(PDO::FETCH_ASSOC); }
    public function setRole(int $id,string $role): bool { $s=$this->pdo->prepare('UPDATE users SET role=? WHERE id=?'); return $s->execute([$role,$id]); }
    public function delete(int $id): bool { $s=$this->pdo->prepare('DELETE FROM users WHERE id=?'); return $s->execute([$id]); }
}
