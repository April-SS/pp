<?php
  $pdo = require_once 'database.php';

    session_start();

    $statement = $pdo->prepare('SELECT * FROM person WHERE user_id = :user_id');
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // function logout()
    // {
    //     session_unset();
    //     session_destroy();
    //     header('Location: Log_in.php');
    // }

   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        
        @import url('https://fonts.googleapis.com/css2?family=Dosis&display=swap');
        body {
            font-family: 'Dosis', sans-serif;

            overflow: hidden;
            /* overflow-y:hidden; */
             background-color: #ececec;
            /* background-image: url("image/read.svg") ;       
        background-repeat: no-repeat;
  background-attachment: fixed; 
  background-position: left center;
   background-size: cover; */

        }

        .content{
            height:850px;
            overflow-y: scroll;
            /* background-color:rgb(209, 231, 221); */
        }

        .green{
            width:100%; 
            background-color:rgb(0, 96, 68); 
            color:white;
        }
    </style>
    
    <title>KFUPM_Library</title>
</head>
<body>
<nav class="navbar fixed-top navbar-expand-lg navbar-red py-0 rounded-bottom" id="navbar" style=" background-color: rgb(8, 53, 39)">
  <div class="container-fluid">
    <label class="navbar-brand align-items-baseline" style="color:white;" >KFUPM_Library</label>
    <div class="d-flex flex-row bd-highlight">
        <div class="btn p-2 bd-highlightl"><a href="Profile.php?user_id:<?php echo $user['user_id']?>" style="color:white;text-decoration: none; " ><?php echo $user['fname']; ?>_Profile</a></div>
        <div  class="btn p-2 bd-highlight "><a href="Logout.php" style="color:white;text-decoration: none;" >Logout</a></div>
    </div>
  </div>
</nav>
 <!-- end the navbar -->

<div class="  ">
    <div class="row justify-content-between d-flex">

    <!-- these complated div's are in the footer  -->