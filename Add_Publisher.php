<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST['email'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];         

        if (!$name || !$email || !$phone) {
            header('Location: Publishers.php');
            exit;
        }

      
        $statement = $pdo->prepare("INSERT INTO publisher  (email, name, phone )
                                    VALUES (:email, :name, :phone); ");
        $statement->bindValue(':email', $email);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':phone', $phone);
    
        $statement->execute();

        header('Location: Publishers.php');
        
    
    }
?>
        <div class="col-10  pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >Add Publisher</h3>
            </div>

            <div class="overflow-auto container-fluid">
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
                            <label class="form-label ps-2" >phone</label>
                            <input class="form-control rounded-pill" name="phone" type="text" value="" >
                            </fieldset>
                        </div>
                    </div>
            
                    <div class="d-flex gap-2 justify-content-end pt-2">
                        <a class="rounded-pill btn btn-outline-secondary " href="Publishers.php">Cancel, back to Publishers</a>
                        <button type="submit" class="rounded-pill btn btn-outline-success">Register</button>
                    </div>
                </form>
            </div>
        </div>


<?php require_once "parts/footer.php"?>