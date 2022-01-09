<?php
    session_start();

$pdo = require_once 'database.php';

$ISBN = $_POST['ISBN'] ?? null;
if (!$ISBN) {
    header('Location: Library_books.php');
    exit;
}

$statement = $pdo->prepare('DELETE FROM book_item WHERE ISBN = :ISBN ;');       
$statement->bindValue(':ISBN',$ISBN);
$statement->execute();

$statement = $pdo->prepare('DELETE FROM categorize_as WHERE ISBN = :ISBN ;');       
$statement->bindValue(':ISBN',$ISBN);
$statement->execute();

$statement = $pdo->prepare('DELETE FROM written_by WHERE ISBN = :ISBN ;');       
$statement->bindValue(':ISBN',$ISBN);
$statement->execute();

$statement = $pdo->prepare('DELETE FROM book WHERE ISBN = :ISBN ;');       
$statement->bindValue(':ISBN',$ISBN);
$statement->execute();



header('Location: Library_books.php');
