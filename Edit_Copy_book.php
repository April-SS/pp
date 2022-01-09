<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $barcode = $_GET['barcode'];

    $statement = $pdo->prepare('SELECT * FROM book_item WHERE barcode = :barcode');
    $statement->bindValue(':barcode', $barcode);
    $statement->execute();
    $book_item = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM libraries');
    $statement->execute();
    $libraries = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $Copy_Num = $_POST['Copy_Num'];
        $rack_number = $_POST['rack_number'];
        $status = $_POST['status'];
        $library = $_POST['radioLibrary'];

         
    
        if (!$Copy_Num || !$rack_number || !$status || !$library  ) {
            $h = "Location: Book_details.php?barcode=". $barcode;
            header($h);
            exit;
        }

        

      
        $statement = $pdo->prepare("UPDATE book_item SET Copy_Num = :Copy_Num, 
                                                         rack_number = :rack_number, 
                                                         status = :status,
                                                         library_id = :radioLibrary WHERE barcode = :barcode");
        $statement->bindValue(':Copy_Num', $Copy_Num);
        $statement->bindValue(':rack_number', $rack_number);
        $statement->bindValue(':status', $status);
        $statement->bindValue(':radioLibrary', $library);
        $statement->bindValue(':barcode', $barcode);
    
        $statement->execute();

        $h = "Location: Book_details.php?barcode=". $barcode;
        header($h);
        
    
    }

?>
        <div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >Edit Copy Book</h3>
            </div>

            <div class=" pt-3 overflow-auto container-fluid">
                <form method="post" action="" enctype="multipart/form-data">

                    <div class="d-flex gap-3">
                        <div class="form-group w-100">
                            <fieldset >
                                <label class="form-label ps-2" for="disabledInput">Copy Number > 1</label>
                                <input class="form-control rounded-pill" name="Copy_Num" type="text" value="<?php echo $book_item['Copy_Num'] ?>" >
                            </fieldset>
                        </div>
                    
                        <div class="form-group w-100">
                            <fieldset >
                                <label class="form-label ps-2" for="disabledInput">Rack Number</label>
                                <input class="form-control rounded-pill" name="rack_number" type="text" value="<?php echo $book_item['rack_number'] ?>" >
                            </fieldset>
                        </div>
                    </div>
                    
                    <div class="form-group w-100 pt-2">
                        <fieldset >
                            <label class="form-label ps-2" for="disabledInput">Status</label>
                            <input class="form-control rounded-pill" name="status"  type="text" value="<?php echo $book_item['status']?>" >
                        </fieldset>
                    </div>
                    
                    <div class="">
                        <legend class="mt-4">From Library</legend>
                        <?php foreach ($libraries as $i => $library) { ?>
                            <div>
                                <input type="radio" name="radioLibrary" value="<?php echo $library['library_id']?>" class="radio" <?php if($book_item['library_id'] == $library['library_id']) echo 'checked' ?>/> <?php echo $library['name']?>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <div class="d-flex gap-2 justify-content-end mt-3">
                        <a class="rounded-pill btn btn-outline-secondary " href="Book_details.php?barcode=<?php echo $barcode ?>">Cancel</a>
                        <button type="submit" class="rounded-pill btn btn-outline-success">Edit</button>
                    </div>
                </form>
            </div>
        </div>


<?php require_once "parts/footer.php"?>