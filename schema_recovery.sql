-- Green-Wizard database schema recovery
-- Reconstructed from PHP queries and the existing users.sql dump.
-- Database used by root connect.php: login
-- This file creates schema only; it does not restore deleted user/action/emission records.
-- Review the notes below before importing into a production database.

CREATE DATABASE IF NOT EXISTS `login`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `login`;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `fName` VARCHAR(50) DEFAULT NULL,
  `lName` VARCHAR(50) DEFAULT NULL,
  `name` VARCHAR(100) DEFAULT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `reset_token` VARCHAR(255) DEFAULT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `avatar` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `actions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `impact_score` DECIMAL(10,2) DEFAULT NULL,
  `difficulty_level` VARCHAR(50) DEFAULT NULL,
  `category` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_actions_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `user_selected_actions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `action_id` INT(11) NOT NULL,
  `status` ENUM('pending','completed') NOT NULL DEFAULT 'pending',
  `selected_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_usa_user_status` (`user_id`, `status`),
  KEY `idx_usa_action` (`action_id`),
  CONSTRAINT `fk_usa_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_usa_action` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `emissions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `household` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `flights` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `car` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `motorbike` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `publicTransport` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `lifestyle` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `recorded_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_emissions_user_recorded` (`user_id`, `recorded_at`),
  CONSTRAINT `fk_emissions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- IMPORTANT:
-- 1) Existing users.sql defines users(fName, lName, email, password, reset_token),
--    while register.php/profile.php also use name, address, avatar. Both sets are
--    included so those code paths can run; adjust the PHP to use one naming scheme later.
-- 2) actions and emissions columns are inferred from SQL queries in the PHP files.
--    Verify data types/defaults against the original phpMyAdmin schema if a backup exists.
-- 3) projectdone/shop_db.sql is a separate database (shop_db) for the Eco Shop.
--    Import that file separately if the shop database was also deleted.
