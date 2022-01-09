<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST['email'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
         
    
        if (!$fname || !$lname  ) {
            header('Location: All_Authors.php');
            exit;
        }

      
        $statement = $pdo->prepare("INSERT INTO author  (email, fname, mname, lname)
                                                VALUES  (:email, :fname, :mname, :lname); ");
        $statement->bindValue(':email', $email);
        $statement->bindValue(':fname', $fname);
        $statement->bindValue(':mname', $mname);
        $statement->bindValue(':lname', $lname);
    
        $statement->execute();

        header('Location: All_Authors.php');
        
    
    }

?>
        <div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >New_Author</h3>
            </div>

            <div class="pt-3 overflow-auto container-fluid">
                <form method="post" action="">
                    <div class="col-6 form-group w-100">
                        <fieldset >
                        <label class="form-label ps-2">Email</label>
                        <input class="form-control rounded-pill" name="email" type="email" value="" >
                        </fieldset>
                    </div>
            

            
                    <div class="row mb-3 pt-2">
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
            
                    <div class="d-flex gap-2 justify-content-end pt-2">
                        <a class="rounded-pill btn btn-outline-secondary " href="All_Authors.php">Cancel, back to All_Authors</a>
                        <button type="submit" class="rounded-pill btn btn-outline-success">Register</button>
                    </div>
                </form>
            </div>
        </div>


<?php require_once "parts/footer.php"?>