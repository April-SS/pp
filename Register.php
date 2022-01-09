<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST['email'];
        $phone = $_POST['phone_number'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $user_type = $_POST['user_type'];
        $gender = $_POST['gender'];
        $password = $_POST['password'];
         
    
        if (!$email || !$fname || !$lname || !$password  ) {
            header('Location: All_Members.php');
            exit;
        }

      
        $statement = $pdo->prepare("INSERT INTO person  (email, phone_number, fname, mname, lname, user_type, gender, password)
                                                VALUES  (:email, :phone_number,:fname, :mname, :lname, :user_type, :gender, :password); ");
        $statement->bindValue(':email', $email);
        $statement->bindValue(':phone_number', $phone);
        $statement->bindValue(':fname', $fname);
        $statement->bindValue(':mname', $mname);
        $statement->bindValue(':lname', $lname);
        $statement->bindValue(':user_type', $user_type);
        $statement->bindValue(':gender', $gender);
        $statement->bindValue(':password', $password);
    
        $statement->execute();

        $statement = $pdo->prepare('SELECT * FROM person WHERE email = :email');
        $statement->bindValue(':email', $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        $statement = $pdo->prepare('INSERT INTO register_member (user_id_librarian, user_id, register_membership_date)
                                                        VALUES  (:user_id_librarian, :user_id, :register_membership_date)');

        $statement->bindValue(':user_id_librarian',$_SESSION['user_id']);
        $statement->bindValue(':user_id', $user['user_id']);
        $statement->bindValue(':register_membership_date', date("Y/m/d"));
        $statement->execute();

        $statement = $pdo->prepare('INSERT INTO member (user_id_member) value (:user_id)');
        $statement->bindValue(':user_id',$user['user_id']);
        $statement->execute();

        $statement = $pdo->prepare('SELECT * FROM member WHERE user_id_member = :user_id');
        $statement->bindValue(':user_id',$user['user_id']);
        $statement->execute();
        $member = $statement->fetch(PDO::FETCH_ASSOC);

        if($user['user_type'] == 'Librarian'){
            $statement = $pdo->prepare('INSERT INTO librarian (user_id_librarian) value (:user_id_member)');
            $statement->bindValue(':user_id_member',$member['user_id_member']);
            $statement->execute();
        }

        

        header('Location: All_Members.php');
        
    
    }

?>
        <div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >Register new Account</h3>
            </div>

            <div class="pt-2 overflow-auto container-fluid">
                <form method="post" action="">
                    <div class="row mb-3">
                        <div class="col-6 form-group">
                            <fieldset >
                            <label class="form-label ps-2">Email</label>
                            <input class="form-control rounded-pill" name="email" type="email" value="" >
                            </fieldset>
                        </div>
            
                        <div class="col-6 form-group">
                            <fieldset >
                            <label class="form-label ps-2" >Phone_Number</label>
                            <input class="form-control rounded-pill" name="phone_number"  type="text" value="" >
                            </fieldset>
                        </div>
                    </div>
            
                    <div class="row mb-3">
                        <div class="col-4 form-group">
                            <fieldset >
                            <label class="form-label ps-2" >First_Name</label>
                            <input class="form-control rounded-pill" name="fname" type="text" value="" >
                            </fieldset>
                        </div>
            
                        <div class="col-4 form-group">
                            <fieldset >
                            <label class="form-label ps-2" >Middle_Name</label>
                            <input class="form-control rounded-pill" name="mname" type="text" value="" >
                            </fieldset>
                        </div>
            
                        <div class="col-4 form-group">
                            <fieldset >
                            <label class="form-label ps-2" >Last_Name</label>
                            <input class="form-control rounded-pill" name="lname" type="text" value="" >
                            </fieldset>
                        </div>
                    </div>
            
                    <div class="row mb-3">
                        <div class="col-6 form-group">
                            <fieldset >
                            <label class="form-label ps-2" for="disabledInput">User Type</label>
                            <input class="form-control rounded-pill" id="disabledInput" name="user_type" type="text" placeholder="" >
                            </fieldset>
                        </div>
            
                        <div class="col-6 form-group">
                            <fieldset >
                            <label class="form-label ps-2" >Gender</label>
                            <input class="form-control rounded-pill"  name="gender" type="text" value="" >
                            </fieldset>
                        </div>
                    </div>

                    <div class="col-6 form-group">
                        <fieldset >
                        <label class="form-label ps-2" >Password</label>
                        <input class="form-control rounded-pill"  name="password" type="text" value="">
                        </fieldset>
                    </div>
            
                    <div class="d-flex gap-2 justify-content-end">
                        <a class="rounded-pill btn btn-outline-secondary" href="All_Members.php">Cancel, back to All_Members</a>
                        <button type="submit" class="rounded-pill btn btn-outline-success">Register</button>
                    </div>
                </form>
            </div>
        </div>


<?php require_once "parts/footer.php"?>