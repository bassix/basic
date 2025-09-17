# Navigation

Here is an **SQL structure** for a navigation tree table using the **Nested Set Model** in **MariaDB**:  

```sql
CREATE TABLE navigation (
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
);
```

Explanation of the columns:

- **id**: Primary key.
- **title**: The name of the navigation item.
- **lft / rgt**: The left and right values for the Nested Set Model.
- **parent_id**: References the parent element (optional).
- **depth**: Indicates the depth of the navigation (root = 0).
- **url**: Optional URL for the navigation item.
- **sort_order**: Controls the order within a level.
- **created_at / updated_at**: Automatic timestamps for tracking changes.
- **Constraints & Indexes**: Performance optimizations and data integrity.

## Example Navigation Structure

Assume we have the following tree structure:

```
Home
├── About Us
│   ├── Team
│   ├── History
├── Services
│   ├── Web Design
│   ├── SEO
└── Contact
```

For this structure, the **Nested Set values** in the database might look like this:

```sql
INSERT INTO navigation (id, title, lft, rgt, parent_id, depth, url, sort_order) VALUES
(1, 'Home', 1, 14, NULL, 0, '/', 1),
(2, 'About Us', 2, 7, 1, 1, '/about-us', 1),
(3, 'Team', 3, 4, 2, 2, '/about-us/team', 1),
(4, 'History', 5, 6, 2, 2, '/about-us/history', 2),
(5, 'Services', 8, 13, 1, 1, '/services', 2),
(6, 'Web Design', 9, 10, 5, 2, '/services/web-design', 1),
(7, 'SEO', 11, 12, 5, 2, '/services/seo', 2),
(8, 'Contact', 15, 16, 1, 1, '/contact', 3);
```

## Queries for the Nested Set Model

**Retrieve the entire navigation (hierarchically sorted)**:

```sql
SELECT * FROM navigation ORDER BY lft;
```

**Find all child elements of a node**:

```sql
SELECT * FROM navigation WHERE lft BETWEEN 2 AND 7 ORDER BY lft;
```

**Find the direct parent node of an element**:

```sql
SELECT p.*
FROM navigation AS n
JOIN navigation AS p ON n.parent_id = p.id
WHERE n.id = 3;
```

**Find all parent nodes of an element (breadcrumbs)**:

```sql
SELECT parent.*
FROM navigation AS node
JOIN navigation AS parent ON node.lft BETWEEN parent.lft AND parent.rgt
WHERE node.id = 6
ORDER BY parent.lft;
```

Let me know if you need any modifications (e.g., more fields or optimizations)! 😊
