<?php
    session_start();

$pdo = require_once 'database.php';

$order_id = $_GET['order_id'] ?? null;
$barcode = $_GET['barcode'] ?? null;
if (!$order_id || !$barcode) {
    header('Location: Check_Out_Librarian.php');
    exit;
}

$statement = $pdo->prepare("DELETE FROM reserve WHERE order_id = :order_id;");
$statement->bindValue(':order_id', $order_id);
$statement->execute();

$statement = $pdo->prepare("DELETE FROM order_ WHERE order_id = :order_id;");
$statement->bindValue(':order_id', $order_id);
$statement->execute();

$statement = $pdo->prepare("UPDATE book_item SET status = :status WHERE barcode = :barcode");
$statement->bindValue(':status', 'Available');
$statement->bindValue(':barcode', $barcode);
$statement->execute();



header('Location: Check_Out_Librarian.php');
