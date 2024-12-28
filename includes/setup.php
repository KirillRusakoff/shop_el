<?php
function initializeDatabase($pdo) {
    // Создание таблицы категорий
    $query1 = "CREATE TABLE IF NOT EXISTS categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL
            )";
    $pdo->exec($query1);

    // Создание таблицы продуктов
    $query2 = "CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                description TEXT,
                stock INT NOT NULL DEFAULT 0,
                price DECIMAL(10, 2) NOT NULL
            )";
    $pdo->exec($query2);

    // Создание таблицы связей между продуктами и категориями
    $query3 = "CREATE TABLE IF NOT EXISTS product_category (
                product_id INT,
                category_id INT,
                PRIMARY KEY (product_id, category_id),
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
                FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
            )";
    $pdo->exec($query3);

    // Создание таблицы изображений продуктов
    $query4 = "CREATE TABLE IF NOT EXISTS product_images (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT,
                image_path VARCHAR(255) NOT NULL,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            )";
    $pdo->exec($query4);

    // Добавление тестовых данных, если их нет
    $categoryCheck = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    if ($categoryCheck == 0) {
        // Добавление категорий
        $pdo->exec("INSERT INTO categories (name) VALUES ('Категория 1'), ('Категория 2')");

        // Добавление продуктов
        $pdo->exec("INSERT INTO products (name, description, stock, price) VALUES 
                    ('Товар 1', 'Описание товара 1', 10, 500),
                    ('Товар 2', 'Описание товара 2', 6, 1500),
                    ('Товар 3', 'Описание товара 3', 5, 300),
                    ('Товар 4', 'Описание товара 4', 8, 800),
                    ('Товар 5', 'Описание товара 5', 7, 1000),
                    ('Товар 6', 'Описание товара 6', 12, 1200),
                    ('Товар 7', 'Описание товара 7', 0, 500),
                    ('Товар 8', 'Описание товара 8', 0, 400),
                    ('Товар 9', 'Описание товара 9', 10, 100),
                    ('Товар 10', 'Описание товара 10', 3, 1100),
                    ('Товар 11', 'Описание товара 11', 10, 1700),
                    ('Товар 12', 'Описание товара 12', 12, 200)");

        // Добавление связей между продуктами и категориями
        $pdo->exec("INSERT INTO product_category (product_id, category_id) VALUES 
                    (1, 1), (2, 1), (3, 2), (4, 2), (5, 1), 
                    (6, 2), (7, 1), (8, 2), (9, 1), (10, 2), 
                    (11, 1), (12, 2)");

        // Добавление изображений продуктов
        $pdo->exec("INSERT INTO product_images (product_id, image_path) VALUES 
                    (1, 'product1.jpg'),
                    (2, 'product2.jpg'), (3, 'product3.jpg'),
                    (4, 'product4.jpg'), (5, 'product5.jpg'),
                    (6, 'product6.jpg'), (7, 'product7.jpg'),
                    (8, 'product8.jpg'), (9, 'product9.jpg'),
                    (10, 'product10.jpg'), (11, 'product11.jpg'),
                    (12, 'product12.jpg')");
    }
}
?>
