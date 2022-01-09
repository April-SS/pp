<?php
    session_start();

$pdo = require_once 'database.php';

$user_id = $_POST['user_id'] ?? null;
if (!$user_id) {
    header('Location: All_Members.php');
    exit;
}

$statement = $pdo->prepare('INSERT INTO cancel_member (user_id_librarian, user_id, cancel_membership_date)
                            VALUES  (:user_id_librarian, :user_id, :cancel_membership_date)');
        
$statement->bindValue(':user_id_librarian',$_SESSION['user_id']);
$statement->bindValue(':user_id', $user_id);
$statement->bindValue(':cancel_membership_date', date("Y/m/d"));
$statement->execute();



header('Location: All_Members.php');
