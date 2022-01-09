<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $barcode = $_GET['barcode'] ?? null;
    if (!$barcode) {
    header('Location: Library_books.php');
    exit;
    }

    $statement = $pdo->prepare('SELECT b.*, i.* FROM book b JOIN book_item i ON b.ISBN = i.ISBN WHERE barcode = :barcode');
    $statement->bindValue(':barcode', $barcode);
    $statement->execute();
    $book = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT a.fname, a.lname FROM author a JOIN written_by w ON w.author_id = a.author_id AND w.ISBN = :ISBN ');
    $statement->bindValue(':ISBN', $book['ISBN']);
    $statement->execute();
    $authors = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT s.name FROM subject_category s JOIN categorize_as c ON c.subject_id = s.subject_id AND c.ISBN = :ISBN ');
    $statement->bindValue(':ISBN', $book['ISBN']);
    $statement->execute();
    $subjects = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT DISTINCT p.name FROM book b JOIN publisher p ON p.publisher_id = b.publisher_id WHERE p.publisher_id = :publisher_id');
    $statement->bindValue(':publisher_id', $book['publisher_id']);
    $statement->execute();
    $publisher = $statement->fetch(PDO::FETCH_ASSOC);

    $textSubjects = "";
    foreach ($subjects as $subject){
        $textSubjects .= $subject['name'] . ", ";
    }

    $textAuthors = "";
    foreach ($authors as $author){
        $textAuthors .= $author['fname'] . " " . $author['lname'] . ", ";
    }

    $statement = $pdo->prepare('SELECT lib.name FROM libraries lib JOIN book_item i ON lib.library_id = :library_id');
    $statement->bindValue(':library_id', $book['library_id']);
    $statement->execute();
    $library = $statement->fetch(PDO::FETCH_ASSOC);
    // echo '<pre>';
    //     var_dump($library);
    //     echo '</pre>';
    

?>
    <div class="col-10 pe-5  rounded pt-5 mt-5" style="text-align: justify;">
        <div class="">
                <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" ><?php echo $book['title'] . " Book_Details"?></h3>
        </div>

        <div class="row overflow-auto container-fluid">
            <div class="col-4 d-flex justify-content-center">
                <?php if ($book['image']): ?>
                    <img src="<?php echo $book['image'] ?>" alt="<?php echo $book['image'] ?>" style=" width: 300px;">
                <?php endif; ?>
            </div>

            <div class="col-8">
                <div class="form-group pt-2">
                    <fieldset disabled="">
                        <label class="form-label ps-2" for="disabledInput">Title</label>
                        <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $book['title']?>" disabled="">
                    </fieldset>
                </div>

                <div class="d-flex gap-3 pt-2">
                    <div class="form-group w-100">
                        <fieldset disabled="">
                            <label class="form-label ps-2" for="disabledInput">Published Year</label>
                            <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $book['publish_year']?>" disabled="">
                        </fieldset>
                    </div>

                    <div class="form-group w-100">
                        <fieldset disabled="">
                            <label class="form-label ps-2" for="disabledInput">Published Month</label>
                            <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $book['publish_month']?>" disabled="">
                        </fieldset>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <div class="form-group w-100">
                        <fieldset disabled="">
                            <label class="form-label ps-2" for="disabledInput">Barcode</label>
                            <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $book['barcode']?>" disabled="">
                        </fieldset>
                    </div>

                    <div class="form-group w-100">
                        <fieldset disabled="">
                            <label class="form-label ps-2" for="disabledInput">Copy_Number</label>
                            <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $book['Copy_Num']?>" disabled="">
                        </fieldset>
                    </div>

                    <div class="form-group w-100">
                        <fieldset disabled="">
                            <label class="form-label ps-2" for="disabledInput">Rack_Number</label>
                            <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $book['rack_number']?>" disabled="">
                        </fieldset>
                    </div>
                </div>


                <div class="form-group pt-2">
                    <fieldset disabled="">
                        <label class="form-label ps-2" for="disabledInput">Subject Category</label>
                        <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $textSubjects ?>" disabled="">
                    </fieldset>
                </div>


                <div class="form-group pt-2">
                    <fieldset disabled="">
                        <label class="form-label ps-2" for="disabledInput">Author/s, written_by</label>
                        <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $textAuthors ?>" disabled="">
                    </fieldset>
                </div>

                <div class="form-group pt-2">
                    <fieldset disabled="">
                        <label class="form-label ps-2 " for="disabledInput">Published by</label>
                        <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $publisher['name'] ?>" disabled="">
                    </fieldset>
                </div>

                <div class="d-flex gap-2 pt-2">
                    <div class="form-group w-100">
                        <fieldset disabled="">
                            <label class="form-label ps-2" for="disabledInput">From Library</label>
                            <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $library['name'] ?>" disabled="">
                        </fieldset>
                    </div>

                    <div class="form-group w-100">
                        <fieldset disabled="">
                            <label class="form-label ps-2" for="disabledInput">Status</label>
                            <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $book['status']?>" disabled="">
                        </fieldset>
                    </div>
                </div>

                <div class="pt-2 d-flex justify-content-end gap-2 pt-4">
                <?php if($user['user_type'] == "Librarian") { ?>
                    <?php if( $book['Copy_Num'] == 1) { ?>
                        <form method="post" action="Delete_book.php" style="display: inline-block"  >
                            <input  type="hidden" name="ISBN" value="<?php echo $book['ISBN'] ?>"/>
                            <button type="submit" class="btn  btn-outline-danger rounded " >Delete, Be careful You will delelte all the other copies for this book, The books must be in the library and not be reserved</button>
                        </form>
                        <a class=" btn btn-outline-success rounded  " href="Edit_book.php?ISBN=<?php echo $book['ISBN'] ?>&barcode=<?php echo $barcode?>">Edit Book</a>
                    <?php } else { ?>
                        <form method="post" action="Delete_bookCopy.php" style="display: inline-block"  >
                            <input  type="hidden" name="barcode" value="<?php echo $book['barcode'] ?>"/>
                            <button type="submit" class="btn  btn-outline-danger rounded" >Delete, The book must be in the library and not be reserved</button>
                        </form>
                        <?php } ?>
                        <a class=" btn btn-outline-success rounded  " href="Edit_Copy_book.php?barcode=<?php echo $book['barcode'] ?>">Edit Copy Book</a>
                <?php } ?>    
                        <a class=" btn btn-outline-success rounded  " href="Library_books.php">Back to Library Books</a>
                </div>        
            </div>
        </div>
    </div>


    <?php require_once "parts/footer.php"?>