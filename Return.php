<?php
    session_start();

$pdo = require_once 'database.php';

$order_id = $_GET['order_id'] ?? null;
$barcode = $_GET['barcode'] ?? null;
if (!$order_id || !$barcode) {
    header('Location: Check_Out_Librarian.php');
    exit;
}


$statement = $pdo->prepare("INSERT INTO return_book  (barcode, order_id, return_date) VALUES  (:barcode, :order_id, :return_date);");
$statement->bindValue(':barcode', $barcode);
$statement->bindValue(':order_id', $order_id);
$statement->bindValue(':return_date', date('Y-m-d'));
$statement->execute();

$statement = $pdo->prepare("UPDATE book_item SET status = :status WHERE barcode = :barcode");
$statement->bindValue(':status', 'Available');
$statement->bindValue(':barcode', $barcode);
$statement->execute();



header('Location: Check_Out_Librarian.php');
