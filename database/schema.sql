-- Generic CRUD Ujikom Practice
-- Import this file using phpMyAdmin or the MySQL command line.
CREATE DATABASE IF NOT EXISTS generic_crud_ujikom
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE generic_crud_ujikom;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS master_records;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(60) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  full_name VARCHAR(120) NOT NULL,
  role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE master_records (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  record_code VARCHAR(50) NOT NULL UNIQUE,
  name VARCHAR(120) NOT NULL,
  category VARCHAR(80) NOT NULL,
  description VARCHAR(1000) NULL,
  numeric_value DECIMAL(14,2) NOT NULL DEFAULT 0.00,
  status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
  created_by BIGINT UNSIGNED NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_master_records_created_by FOREIGN KEY (created_by) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE SET NULL,
  INDEX idx_master_records_name (name),
  INDEX idx_master_records_category (category),
  INDEX idx_master_records_status (status)
) ENGINE=InnoDB;

-- Account demo lokal: username=admin, password=admin123
-- Change the password before any public deployment.
INSERT INTO users (username, password_hash, full_name, role) VALUES
('admin', '$2y$12$49rzuF2rLyhHUsOgzgGqb.TxKzqdnTBxarcK8gpNDDVXsDtuWZfPO', 'Administrator Demo', 'admin');

INSERT INTO master_records (record_code, name, category, description, numeric_value, status, created_by) VALUES
('DATA-001', 'Contoh data aktif', 'Kategori A', 'Contoh record untuk mencoba fitur baca dan edit.', 10.00, 'active', 1),
('DATA-002', 'Contoh data kedua', 'Kategori B', 'Record demo kedua. Ganti dengan data sesuai kebutuhan tugas.', 25.50, 'active', 1),
('DATA-003', 'Contoh data nonaktif', 'Kategori A', 'Contoh untuk menguji filter dan tampilan status.', 0.00, 'inactive', 1);
