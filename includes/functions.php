<?php
// Получение списка категорий
function fetchCategories($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories");
    return $stmt->fetchAll();
}

// Получение списка товаров
function fetchProducts($pdo, $limit = null, $categoryId = null) {
    $query = "SELECT products.*, GROUP_CONCAT(images.image_path) AS images
              FROM products
              LEFT JOIN product_images AS images ON products.id = images.product_id";

    if ($categoryId) {
        $query .= " INNER JOIN product_category AS pc ON products.id = pc.product_id
                    WHERE pc.category_id = :categoryId";
    }

    $query .= " GROUP BY products.id ORDER BY products.price ASC";

    if ($limit) {
        $query .= " LIMIT :limit";
    }

    $stmt = $pdo->prepare($query);

    if ($categoryId) {
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
    }
    if ($limit) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}
?>
