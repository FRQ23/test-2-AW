-- Bons-AI SQL script
-- Crea la base de datos `bonsai` con las tablas necesarias para el CRUD

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `bonsai`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `bonsai`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(120) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
  `accepted_terms` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuarios de prueba
-- CREDENCIALES DE ADMINISTRADOR:
-- Email: admin@bonsai.com
-- Password: Admin@123
-- 
-- CREDENCIALES DE USUARIO NORMAL:
-- Email: usuario@bonsai.com  
-- Password: Usuario@123
INSERT INTO `users` (`id`, `full_name`, `email`, `password_hash`, `is_admin`, `accepted_terms`, `created_at`)
VALUES
  (1, 'Administrador Bons-AI', 'admin@bonsai.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 1, '2025-11-25 23:08:10'),
  (2, 'Usuario Demo', 'usuario@bonsai.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 1, '2025-11-26 01:10:26')
ON DUPLICATE KEY UPDATE
  `full_name` = VALUES(`full_name`),
  `password_hash` = VALUES(`password_hash`),
  `is_admin` = VALUES(`is_admin`),
  `accepted_terms` = VALUES(`accepted_terms`);

ALTER TABLE `users` AUTO_INCREMENT = 3;

CREATE TABLE IF NOT EXISTS `quotes` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `full_name` VARCHAR(120) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(30),
  `bonsai_type` VARCHAR(60) NOT NULL,
  `size` VARCHAR(60) NOT NULL,
  `budget` VARCHAR(60),
  `message` TEXT,
  `response_message` TEXT,
  `response_sent_at` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `quotes_user_id_fk` (`user_id`),
  CONSTRAINT `quotes_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `quotes` (`id`, `user_id`, `full_name`, `email`, `phone`, `bonsai_type`, `size`, `budget`, `message`, `response_message`, `response_sent_at`, `created_at`)
VALUES
  (1, 1, 'Sample Customer', 'customer@example.com', '+52 664 123 4567', 'juniper', 'medium', '100-250', 'Interested in a medium juniper bonsai.', NULL, NULL, NOW())
ON DUPLICATE KEY UPDATE
  `full_name` = VALUES(`full_name`),
  `bonsai_type` = VALUES(`bonsai_type`),
  `size` = VALUES(`size`);

ALTER TABLE `quotes` AUTO_INCREMENT = 2;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

