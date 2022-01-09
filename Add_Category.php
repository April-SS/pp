<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = $_POST['name'];  

        if (!$name  ) {
            header('Location: Subject_Categories.php');
            exit;
        }

      
        $statement = $pdo->prepare("INSERT INTO subject_category  ( name )
                                    VALUES ( :name ); ");
        $statement->bindValue(':name', $name);    
        $statement->execute();

        header('Location: Subject_Categories.php');
        
    
    }
?>
        <div class="col-10 pe-5 rounded pt-5 mt-5 " style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >Add Category</h3>
            </div>

            <div class=" overflow-auto container-fluid">
                <form method="post" action="">
                    <div class="col-6 form-group w-100">
                        <fieldset >
                        <label class="form-label ps-2">Name</label>
                        <input class="form-control rounded-pill" name="name" type="text" value="" >
                        </fieldset>
                    </div>
            
            
                    <div class="d-flex gap-2 justify-content-end mt-2 pt-3">
                        <a class="rounded-pill btn btn-outline-secondary " href="Subject_Categories.php">Cancel, back to Subject_Categories</a>
                        <button type="submit" class="rounded-pill btn btn-outline-success">Add</button>
                    </div>
                </form>
            </div>
        </div>


<?php require_once "parts/footer.php"?>