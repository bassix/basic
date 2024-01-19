SET foreign_key_checks = 0;

CREATE TABLE `page` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `titel` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `author` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
    `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
    `password` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_name` (`name`),
    KEY `name` (`name`,`password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `todo_type`;
CREATE TABLE `todo_type` (
    `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `todo`;
CREATE TABLE `todo` (
    `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(20) unsigned NOT NULL,
    `type_id` int(20) unsigned NOT NULL,
    `title` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
    `completed` tinyint(1) DEFAULT 0,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `fk_todo_user` (`user_id`),
    KEY `fk_todo_type` (`type_id`),
    CONSTRAINT `fk_todo_type` FOREIGN KEY (`type_id`) REFERENCES `todo_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_todo_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET foreign_key_checks = 1;
