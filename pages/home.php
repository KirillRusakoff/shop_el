<?php
$products = fetchProducts($pdo, 10);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Главная</title>
</head>
<body>
    <header>
        <h1>Магазин</h1>
        <nav>
            <a href="index.php">Главная</a>
            <?php $categories = fetchCategories($pdo); ?>
            <?php foreach ($categories as $category): ?>
                <a href="index.php?page=category&id=<?= $category['id'] ?>"><?= $category['name'] ?></a>
            <?php endforeach; ?>
            <a href="index.php?page=cart">Корзина</a>
        </nav>
    </header>
    <main>
        <h2>10 самых дешевых товаров</h2>
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
