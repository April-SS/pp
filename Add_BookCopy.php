<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $ISBN = $_GET['ISBN'];

    $statement = $pdo->prepare('SELECT * FROM book WHERE ISBN = :ISBN');
    $statement->bindValue(':ISBN', $ISBN);
    $statement->execute();
    $book = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM libraries');
    $statement->execute();
    $libraries = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $Copy_Num = $_POST['Copy_Num'];
        $rack_number = $_POST['rack_number'];
        $library = $_POST['radioLibrary'];
        $status = 'Available';

        if (!$Copy_Num || !$rack_number || !$library) {
            header('Location: Library_books.php');
            exit;
        }

        $statement = $pdo->prepare("INSERT INTO book_item  (ISBN, Copy_Num, rack_number, library_id, status)
                                            VALUES  (:ISBN, :Copy_Num,:rack_number, :library_id, :status);");
        $statement->bindValue(':ISBN', $ISBN);
        $statement->bindValue(':Copy_Num', $Copy_Num);
        $statement->bindValue(':rack_number', $rack_number);
        $statement->bindValue(':library_id', $library);
        $statement->bindValue(':status', $status);
        $statement->execute();

        header('Location: Library_books.php');

        

    }
?>
        <div class="col-10  pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >Add Book Copy of <?php echo $book['title'];?></h3>
            </div>

            <div class=" pt-3 overflow-auto container-fluid">
                <form method="post" action="" enctype="multipart/form-data">

                    <div class="d-flex gap-3">
                        <div class="form-group w-100">
                            <fieldset >
                                <label class="form-label ps-2" for="disabledInput">Copy Number > 1</label>
                                <input class="form-control rounded-pill" name="Copy_Num" type="text" placeholder="" >
                            </fieldset>
                        </div>
    
                        <div class="form-group w-100">
                            <fieldset >
                                <label class="form-label ps-2" for="disabledInput">Rack Number</label>
                                <input class="form-control rounded-pill" name="rack_number" type="text" placeholder="" >
                            </fieldset>
                        </div>
                    </div>

                   
                    <div class="ps-2">
                        <legend class="mt-4 rounded-pill">From Library</legend>
                        <?php foreach ($libraries as $i => $library) { ?>
                            <div>
                                <input type="radio" name="radioLibrary" value="<?php echo $library['library_id']?>" class="radio" /> <?php echo $library['name']?>
                            </div>
                        <?php } ?>
                    </div>


                    
                    


                    <div class="d-flex gap-2 justify-content-end mt-3">
                        <a class="rounded-pill btn btn-outline-secondary " href="Library_books.php">Cancel, back to Library_books</a>
                        <button type="submit" class="rounded-pill btn btn-outline-success">Add</button>
                    </div>
                </form>
            </div>
        </div>


<?php require_once "parts/footer.php"?>