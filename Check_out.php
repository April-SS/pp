<?php
    session_start();

$pdo = require_once 'database.php';

$order_id = $_GET['order_id'] ?? null;
if (!$order_id) {
    header('Location: Check_Out_Librarian.php');
    exit;
}

$statement = $pdo->prepare("UPDATE reserve SET check_out_date = :check_out_date WHERE order_id = :order_id");
        $statement->bindValue(':check_out_date', date('Y-m-d'));
        $statement->bindValue(':order_id', $order_id);
        $statement->execute();



header('Location: Check_Out_Librarian.php');
