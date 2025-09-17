DROP TABLE IF EXISTS `navigation`;
CREATE TABLE `navigation` (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    lft INT UNSIGNED NOT NULL,
    rgt INT UNSIGNED NOT NULL,
    parent_id INT UNSIGNED DEFAULT NULL,
    depth INT UNSIGNED NOT NULL DEFAULT 0,
    url VARCHAR(255) DEFAULT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_nested_sets CHECK (rgt > lft),
    INDEX idx_lft (lft),
    INDEX idx_rgt (rgt),
    INDEX idx_parent (parent_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO navigation (id, title, lft, rgt, parent_id, depth, url, sort_order) VALUES
(1, 'Home', 1, 14, NULL, 0, '/', 1),
(2, 'Über uns', 2, 7, 1, 1, '/ueber-uns', 1),
(3, 'Team', 3, 4, 2, 2, '/ueber-uns/team', 1),
(4, 'Geschichte', 5, 6, 2, 2, '/ueber-uns/geschichte', 2),
(5, 'Leistungen', 8, 13, 1, 1, '/leistungen', 2),
(6, 'Webdesign', 9, 10, 5, 2, '/leistungen/webdesign', 1),
(7, 'SEO', 11, 12, 5, 2, '/leistungen/seo', 2),
(8, 'Kontakt', 15, 16, 1, 1, '/kontakt', 3);
