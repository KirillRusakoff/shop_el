<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    header("Location: index.php?page=cart");
    exit;
}

$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $query = "SELECT * FROM products WHERE id IN ($ids)";
    $cartItems = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Корзина</title>
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
        <h2>Корзина</h2>
        <?php if (!empty($cartItems)): ?>
            <table>
                <tr>
                    <th>Товар</th>
                    <th>Количество</th>
                    <th>Цена</th>
                </tr>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td><?= $_SESSION['cart'][$item['id']] ?></td>
                        <td><?= $item['price'] * $_SESSION['cart'][$item['id']] ?> ₽</td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Корзина пуста.</p>
        <?php endif; ?>
    </main>
</body>
</html>
