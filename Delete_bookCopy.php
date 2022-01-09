<?php
    session_start();

$pdo = require_once 'database.php';

$barcode = $_POST['barcode'] ?? null;


if (!$barcode ) {
    header('Location: Library_books.php');
    exit;
}

$statement = $pdo->prepare('SELECT * FROM book_item WHERE barcode = :barcode; ');
$statement->bindValue(':barcode',$barcode);
$statement->execute();
$book = $statement->fetch(PDO::FETCH_ASSOC);

if($book['status'] == 'Available'){
   $statement = $pdo->prepare('DELETE FROM book_item WHERE barcode = :barcode ;');         
   $statement->bindValue(':barcode',$barcode);
   $statement->execute();
}

header('Location: Library_books.php');