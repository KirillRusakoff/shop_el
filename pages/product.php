<?php
$productId = $_GET['id'] ?? null;
if (!$productId) {
    die("Товар не найден.");
}

$query = "SELECT products.*, GROUP_CONCAT(images.image_path) AS images, 
          GROUP_CONCAT(categories.name SEPARATOR ', ') AS categories
          FROM products
          LEFT JOIN product_images AS images ON products.id = images.product_id
          LEFT JOIN product_category AS pc ON products.id = pc.product_id
          LEFT JOIN categories ON pc.category_id = categories.id
          WHERE products.id = :id
          GROUP BY products.id";

$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Товар не найден.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title><?= $product['name'] ?></title>
</head>
<body>
    <header>
        <h1>Магазин</h1>
        <nav>
            <a href="index.php">Главная</a>
            <a href="index.php?page=cart">Корзина</a>
        </nav>
    </header>
    <main>
        <h2><?= $product['name'] ?></h2>
        <div class="product-detail">
            <div class="images">
                <?php $images = explode(',', $product['images']); ?>
                <?php foreach ($images as $image): ?>
                    <img src="images/<?= $image ?>" alt="<?= $product['name'] ?>">
                <?php endforeach; ?>
            </div>
            <p>Категории: <?= $product['categories'] ?></p>
            <p>Цена: <?= $product['price'] ?> ₽</p>
            <p>Остаток: <?= $product['stock'] ?></p>
            <?php if ($product['stock'] > 0): ?>
                <form action="index.php?page=cart" method="post">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
                    <button type="submit">Добавить в корзину</button>
                </form>
            <?php else: ?>
                <p>Нет в наличии</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
