<?php
$categoryId = $_GET['id'] ?? null;
if (!$categoryId) {
    die("Категория не найдена.");
}

$categoryName = $pdo->prepare("SELECT name FROM categories WHERE id = :id");
$categoryName->execute(['id' => $categoryId]);
$categoryName = $categoryName->fetchColumn();

if (!$categoryName) {
    die("Категория не найдена.");
}

$products = fetchProducts($pdo, null, $categoryId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Категория: <?= $categoryName ?></title>
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
        <h2>Товары в категории: <?= $categoryName ?></h2>
        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="images/<?= $product['images'] ?>" alt="<?= $product['name'] ?>">
                    <h3><?= $product['name'] ?></h3>
                    <p>Цена: <?= $product['price'] ?> ₽</p>
                    <a href="index.php?page=product&id=<?= $product['id'] ?>">Подробнее</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
