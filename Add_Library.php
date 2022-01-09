<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST['email'];
        $name = $_POST['name'];
        $location = $_POST['location'];         
    
        if (!$name || !$location ) {
            header('Location: Libraries.php');
            exit;
        }

      
        $statement = $pdo->prepare("INSERT INTO libraries  (email, name, location )
                                    VALUES (:email, :name, :location); ");
        $statement->bindValue(':email', $email);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':location', $location);
    
        $statement->execute();

        header('Location: Libraries.php');
        
    
    }
?>
        <div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >Add Library</h3>
            </div>

            <div class=" overflow-auto container-fluid">
                <form method="post" action="">
                    <div class="col-6 form-group w-100">
                        <fieldset >
                        <label class="form-label ps-2">Email</label>
                        <input class="form-control rounded-pill" name="email" type="email" value="" >
                        </fieldset>
                    </div>
            
                    <div class="row mb-3">
                        <div class="col-6 form-group">
                            <fieldset >
                            <label class="form-label ps-2" >Name</label>
                            <input class="form-control rounded-pill" name="name" type="text" value="" >
                            </fieldset>
                        </div>
            
                        <div class="col-6 form-group">
                            <fieldset >
                            <label class="form-label ps-2" >Location</label>
                            <input class="form-control rounded-pill" name="location" type="text" value="" >
                            </fieldset>
                        </div>
                    </div>
            
                    <div class="d-flex gap-2 justify-content-end">
                        <a class="rounded-pill btn btn-outline-secondary " href="All_Authors.php">Cancel, back to All_Authors</a>
                        <button type="submit" class="rounded-pill btn btn-outline-success">Register</button>
                    </div>
                </form>
            </div>
        </div>


<?php require_once "parts/footer.php"?>