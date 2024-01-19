
--
-- Table structure for `page` table
--

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
