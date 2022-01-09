<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $statement = $pdo->prepare('SELECT * FROM libraries');
    $statement->execute();
    $libraries = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $title = $_POST['title'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $cost = $_POST['cost'];
        $library = $_POST['radioLibrary'];

        if (!$title || !$start_date || !$end_date || !$cost || !$library) {
            header('Location: Request_books.php');
            exit;
        }

        $statement = $pdo->prepare("INSERT INTO request  (title, start_loan_date, end_loan_date, cost, library_id, user_id_librarian)
                                            VALUES  (:title, :start_loan_date,:end_loan_date, :cost, :library_id, :user_id_librarian);");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':start_loan_date', $start_date);
        $statement->bindValue(':end_loan_date', $end_date);
        $statement->bindValue(':cost', $cost);
        $statement->bindValue(':library_id', $library);
        $statement->bindValue(':user_id_librarian', $_SESSION['user_id']);
        $statement->execute();

       
        header('Location: Request_books.php');
    }


?>
        <div class="col-10 pe-5 rounded  pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 pb-1 " style="" >Main Page</h3>
            </div>

            <div class="pt-3 overflow-auto container-fluid">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <fieldset >
                        <label class="form-label ps-2" >Title</label>
                        <input class="form-control rounded-pill" name="title" type="text" value="" >
                        </fieldset>
                    </div>

                    <div class="d-flex gap-3 mt-2 pt-2">
                        <div class="form-group w-100">
                            <fieldset >
                                <label class="form-label ps-2" for="disabledInput">Start_loan_date</label>
                                <input class="form-control rounded-pill" name="start_date" type="date" placeholder="" >
                            </fieldset>
                        </div>
    
                        <div class="form-group w-100">
                            <fieldset >
                                <label class="form-label ps-2" for="disabledInput">Etart_loan_date</label>
                                <input class="form-control rounded-pill" name="end_date" type="date" placeholder="" >
                            </fieldset>
                        </div>
                    </div>


                    <div class="row pt-2">
                        <div class="col-6">
                            <legend class="mt-4">From Library</legend>
                            <?php foreach ($libraries as $i => $library) { ?>
                                <div>
                                    <input type="radio" name="radioLibrary" value="<?php echo $library['library_id']?>" class="radio rounded-pill" /> <?php echo $library['name']?>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group col-6 mt-4">
                            <fieldset >
                                <label class="form-label ps-2" for="disabledInput">Cost</label>
                                <input class="form-control rounded-pill" name="cost" type="text" placeholder="" >
                            </fieldset>
                        </div>
                    </div>
                    


                    <div class="d-flex gap-2 justify-content-end mt-3 pt-2">
                        <a class="rounded-pill btn btn-outline-secondary " href="Request_books.php">Cancel, back to Requested_Books</a>
                        <button type="submit" class="rounded-pill btn btn-outline-success">Request</button>
                    </div>
                </form>
            </div>
        </div>


<?php require_once "parts/footer.php"?>