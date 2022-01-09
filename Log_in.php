<?php
$pdo = require_once 'database.php';
session_start();
$errors = [];

$email="";
$password="";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $email = $_POST['email'];
  $password = $_POST['password'];

  if(!$email )
    $errors[] = 'Email is Required';

  if(!$password)
    $errors[] = 'Password is required';

  if(empty($errors)){
    $statement = $pdo->prepare('SELECT * FROM person WHERE email = :email AND password = :password');
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if(!$user)
      echo "<script> alert(\"Sorry, your email or password is wrong\")</script>";
    else{
      $statement = $pdo->prepare('SELECT * FROM cancel_member WHERE user_id = :user_id');
      $statement->bindValue(':user_id', $user['user_id']);
      $statement->execute();
      $check = $statement->fetch(PDO::FETCH_ASSOC);
  
      
      if($check)
        echo "<script> alert(\"Sorry, you are canceled\")</script>";
      else{
        $_SESSION['user_id'] = $user['user_id'];
        header('Location: Member_Main.php');
      }
    }
  }
}

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

      body{
        font-family: 'Dosis', sans-serif;

        background-image: url("image/b.jpg") ;       
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position:  center;
        background-size: cover;
      }
    </style>

    <title>KFUPM_Library | Login</title>
</head>
<body class="text-center">
  <nav class="navbar fixed-top navbar-expand-lg navbar-red py-0 " id="navbar" style=" background-color: rgb(8, 53, 39)">
    <div class="container-fluid">
      <label class="navbar-brand align-items-baseline" style="color:white;" >KFUPM_Library</label>
    </div>
  </nav>

  <div class="col-lg-4 col-md-4 col-sm-4 container justify-content-center align-items-center pt-5 mt-5 ms-5 ps-5" style="width: 30%;">
        <!-- Custom styles for this template -->
  <div class=" border border-success border-1 rounded mt-5" style=" background-color: #ececec" >
    <main class="form-signin">
      <form action="" method="post" id="myForm">
        <h1 class="h3 mb-3 fw-normal">Please Log in</h1>
        
        <div class="form-floating" >
          <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
          <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
          <label for="floatingPassword">Password</label>
        </div>

        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?php echo $error ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>

        <div>
          <p> Forget your password? it's OK -> <a href="#" style="color:green; text-decoration: none;">Reset_here</a>.</p>
        </div>
        <button class="w-100 btn btn-lg" style="background-color:rgb(8, 53, 39); color:white;" type="submit">Log in</button>

        <p class="pt-3">Don't hava an account? Please <a href="#" style="color:green; text-decoration: none;">contact_Librarian</a>.</p>
      </form>
    </main>
  </div>
  </div>

<div><div><div>
    <!-- this to adapt the footer.php class -->

<?php require_once "parts/footer.php"?>

  