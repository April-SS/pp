<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $user_id = $_GET['user_id'] ?? $_SESSION['user_id'];

    $statement = $pdo->prepare('SELECT * FROM person WHERE user_id = :user_id');
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
// echo '<pre>';
// echo var_dump($user);
// echo '</pre>';
    if($user['user_type'] == 'Librarian'){
        $statement = $pdo->prepare('SELECT * FROM librarian WHERE user_id_librarian = :user_id');
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $librarian = $statement->fetch(PDO::FETCH_ASSOC);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST['email'];
        $phone = $_POST['phone_number'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $gender = $_POST['gender'];
         
    
        if (!$email || !$fname || !$lname  ) {
            header('Location: Profile.php');
            exit;
        }

        

      
        $statement = $pdo->prepare("UPDATE person SET email = :email, 
                                            phone_number = :phone_number, 
                                            fname = :fname,
                                            mname = :mname,
                                            lname = :lname,
                                            gender = :gender WHERE user_id = :user_id");
        $statement->bindValue(':email', $email);
        $statement->bindValue(':phone_number', $phone);
        $statement->bindValue(':fname', $fname);
        $statement->bindValue(':mname', $mname);
        $statement->bindValue(':lname', $lname);
        $statement->bindValue(':gender', $gender);
        $statement->bindValue(':user_id', $user['user_id']);
    
        $statement->execute();

        if($user['user_type'] == 'Librarian'){
            $statement = $pdo->prepare("UPDATE librarian SET work_hours = :work_hours,
                                        salary = :salary WHERE user_id_librarian = :user_id");
            $statement->bindValue(':work_hours', $_POST['work_hours']);
            $statement->bindValue(':salary', $_POST['salary']);
            $statement->bindValue(':user_id', $librarian['user_id_librarian']);
            $statement->execute();
        }

        $h = "Location: Profile.php?user_id=".$user['user_id'];
        header($h);
        
    
    }
?>

<div class="col-10 pe-5 pt-5 mt-5" style="text-align: justify;">
    <div class="">
        <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >Update_Profile</h3>
    </div>

    <div class="overflow-auto container-fluid">
        <form method="post" action="">
            <div class="row mb-3 pt-2">
                <div class="col-6 form-group">
                    <fieldset >
                    <label class="form-label ps-2">Email</label>
                    <input class="form-control rounded-pill" name="email" type="text" value="<?php echo $user['email']?>" >
                    </fieldset>
                </div>
    
                <div class="col-6 form-group">
                    <fieldset >
                    <label class="form-label ps-2" >Phone_Number</label>
                    <input class="form-control rounded-pill" name="phone_number"  type="text" value="<?php echo $user['phone_number']?>" >
                    </fieldset>
                </div>
            </div>
    
            <div class="row mb-3">
                <div class="col-4 form-group">
                    <fieldset >
                    <label class="form-label ps-2" >First_Name</label>
                    <input class="form-control rounded-pill" name="fname" type="text" value="<?php echo $user['fname']?>" >
                    </fieldset>
                </div>
    
                <div class="col-4 form-group">
                    <fieldset >
                    <label class="form-label ps-2" >Middle_Name</label>
                    <input class="form-control rounded-pill" name="mname" type="text" value="<?php echo $user['mname']?>" >
                    </fieldset>
                </div>
    
                <div class="col-4 form-group">
                    <fieldset >
                    <label class="form-label ps-2" >Last_Name</label>
                    <input class="form-control rounded-pill" name="lname" type="text" value="<?php echo $user['lname']?>" >
                    </fieldset>
                </div>
            </div>
    
            <div class="row mb-3 ">
                <div class="col-6 form-group">
                    <fieldset disabled="">
                    <label class="form-label ps-2" for="disabledInput">You are a</label>
                    <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $user['user_type']?>" disabled="">
                    </fieldset>
                </div>
    
                <div class="col-6 form-group">
                    <fieldset >
                    <label class="form-label ps-2" >Gender</label>
                    <input class="form-control rounded-pill"  name="gender" type="text" value="<?php echo $user['gender']?>" >
                    </fieldset>
                </div>
            </div>
    
            <?php if($user['user_type'] == "Librarian"){?>
                <div class="row mb-3 ">
                    <div class="col-6 form-group">
                        <fieldset>
                        <label class="form-label ps-2" >Work hours</label>
                        <input class="form-control rounded-pill" name="work_hours" type="text" placeholder="<?php echo $librarian['work_hours']?>" >
                        </fieldset>
                    </div>
        
                    <div class="col-6 form-group">
                        <fieldset>
                        <label class="form-label ps-2" >Salary</label>
                        <input class="form-control rounded-pill" name="salary" type="text" placeholder="<?php echo $librarian['salary']?>" >
                        </fieldset>
                    </div>
                </div>
            <?php } ?>
    
            <div class="d-flex gap-2 justify-content-end pt-2">
                <a class="rounded-pill btn btn-outline-secondary " href="Profile.php">Cancel</a>
                <button type="submit" class="rounded-pill btn btn-outline-success">Update</button>
            </div>
        </form>
    </div>
</div>


<?php require_once "parts/footer.php"?>