<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once 'includes/setup.php';

// Проверяем, есть ли таблицы, если нет — создаем
initializeDatabase($pdo);

// Определяем страницу
$page = $_GET['page'] ?? 'home';
$allowed_pages = ['home', 'category', 'product', 'cart'];
if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

require "pages/{$page}.php";
?>