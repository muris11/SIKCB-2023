-- KelasKita CMS - Struktur Database (MySQL 5.7+/MariaDB 10.2+)
-- Catatan:
-- - Pastikan menggunakan charset utf8mb4 untuk dukungan emoji dan aksara penuh
-- - Engine InnoDB diperlukan untuk FOREIGN KEY
-- - Jalankan file ini di phpMyAdmin cPanel Anda

SET NAMES utf8mb4;
SET time_zone = '+00:00';

-- Buat database (opsional, sesuaikan nama database Anda)
-- CREATE DATABASE IF NOT EXISTS `kelaskita_cms` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE `kelaskita_cms`;

-- Hapus tabel jika ada (perhatikan urutan karena foreign key)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS mini_library_members;
DROP TABLE IF EXISTS mini_library;
DROP TABLE IF EXISTS materials;
DROP TABLE IF EXISTS gallery;
DROP TABLE IF EXISTS classes;
DROP TABLE IF EXISTS semesters;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- =========================
-- Tabel Users
-- =========================
CREATE TABLE users (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name           VARCHAR(191) NOT NULL,
  email          VARCHAR(191) NOT NULL,
  password_hash  VARCHAR(255) NOT NULL,
  role           ENUM('user','admin') NOT NULL DEFAULT 'user',
  reset_token    VARCHAR(255) NULL,
  reset_expires  INT UNSIGNED NULL,
  created_at     INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_users_email (email),
  KEY idx_users_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- Tabel Semesters
-- =========================
CREATE TABLE semesters (
  id                INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name              VARCHAR(191) NOT NULL,
  term_label        VARCHAR(100) NOT NULL,
  description       TEXT NOT NULL,
  cover_image       LONGBLOB NULL,
  cover_image_type  VARCHAR(50) NULL,
  created_at        INT UNSIGNED NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- Tabel Classes
-- =========================
CREATE TABLE classes (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  semester_id  INT UNSIGNED NOT NULL,
  name         VARCHAR(191) NOT NULL,
  status       VARCHAR(50) NOT NULL DEFAULT 'aktif',
  description  TEXT NOT NULL,
  teacher      VARCHAR(191) NOT NULL,
  schedule     VARCHAR(191) NOT NULL,
  sks          INT NOT NULL DEFAULT 0,
  cover_url    VARCHAR(512) NULL,
  pj_user_id   INT UNSIGNED NULL,
  PRIMARY KEY (id),
  KEY idx_classes_semester (semester_id),
  KEY idx_classes_pj (pj_user_id),
  CONSTRAINT fk_classes_semester FOREIGN KEY (semester_id) REFERENCES semesters(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_classes_pj_user  FOREIGN KEY (pj_user_id)  REFERENCES users(id)     ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- Tabel Gallery (gambar disimpan sebagai blob)
-- =========================
CREATE TABLE gallery (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  semester_id  INT UNSIGNED NOT NULL,
  image_data   LONGBLOB NOT NULL,
  image_type   VARCHAR(50) NOT NULL,
  image_name   VARCHAR(255) NOT NULL,
  caption      VARCHAR(255) NULL,
  created_at   INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  KEY idx_gallery_semester (semester_id),
  CONSTRAINT fk_gallery_semester FOREIGN KEY (semester_id) REFERENCES semesters(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- Tabel Materials (opsional, untuk materi per kelas)
-- =========================
CREATE TABLE materials (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  class_id     INT UNSIGNED NOT NULL,
  title        VARCHAR(191) NOT NULL,
  type         VARCHAR(50)  NOT NULL,
  duration     VARCHAR(50)  NOT NULL,
  file_data    LONGBLOB NULL,
  file_name    VARCHAR(255) NULL,
  file_type    VARCHAR(100) NULL,
  resource_url VARCHAR(512) NULL,
  created_at   INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  KEY idx_materials_class (class_id),
  CONSTRAINT fk_materials_class FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- Tabel Mini Library (kelompok + anggota)
-- image disimpan sebagai data URL (MEDIUMTEXT)
-- =========================
CREATE TABLE mini_library (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  group_name   VARCHAR(191) NOT NULL,
  description  TEXT NOT NULL,
  category     VARCHAR(100) NOT NULL,
  link         VARCHAR(512) NULL,
  image        MEDIUMTEXT NULL,
  created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE mini_library_members (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  mini_library_id  INT UNSIGNED NOT NULL,
  name             VARCHAR(191) NOT NULL,
  PRIMARY KEY (id),
  KEY idx_members_library (mini_library_id),
  CONSTRAINT fk_members_library FOREIGN KEY (mini_library_id) REFERENCES mini_library(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- Seed minimal (opsional)
-- Hapus komentar untuk membuat admin default. Ganti email/password sesuai kebutuhan.
-- Perhatian: Gunakan hash bcrypt dari password_hash('admin123', PASSWORD_DEFAULT)
-- INSERT INTO users (name, email, password_hash, role, created_at) VALUES
--   ('Administrator', 'admin@example.com', '$2y$10$wqf1y1Jv7Qm2C9kR3m6mQOV7kZ8xvAbgNwI6n9mV9GQGJXQ3s8mnu', 'admin', UNIX_TIMESTAMP());
-- (Hash di atas adalah contoh. DIREKOMENDASIKAN untuk membuat hash baru.)

-- Index tambahan untuk pencarian umum
CREATE INDEX idx_semesters_name ON semesters(name);
CREATE INDEX idx_classes_name ON classes(name);
CREATE INDEX idx_gallery_created ON gallery(created_at);

-- Selesai.
