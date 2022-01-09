<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $statement = $pdo->prepare('SELECT * FROM author');
    $statement->execute();
    $authors = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM `subject_category`');
    $statement->execute();
    $Categories = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM libraries');
    $statement->execute();
    $libraries = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM publisher');
    $statement->execute();
    $publishers = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $image = $_POST['image'] ?? "null";
        $title = $_POST['title'];
        $year = $_POST['publish_year'];
        $month = $_POST['publish_month'];
        $publisher = $_POST['radioPublisher'] ?? "null";

        $rack_number = $_POST['rack_number'] ?? "null";
        $library = $_POST['radioLibrary'];
        $Copy_Num = 1;
        $status = 'Available';

        if (!$title || !$year || !$month || !$library) {
            header('Location: Library_books.php');
            exit;
        }

        $statement = $pdo->prepare("INSERT INTO book  (image, title, publish_year, publish_month, publisher_id)
                                            VALUES  (:image, :title,:publish_year, :publish_month, :publisher_id);");
        $statement->bindValue(':image', $image);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':publish_year', $year);
        $statement->bindValue(':publish_month', $month);
        $statement->bindValue(':publisher_id', $publisher);
        $statement->execute();

        $statement = $pdo->prepare('SELECT * FROM book WHERE title = :title');
        $statement->bindValue(':title', $title);
        $statement->execute();
        $book = $statement->fetch(PDO::FETCH_ASSOC);

        $statement = $pdo->prepare("INSERT INTO book_item  (ISBN, Copy_Num, rack_number, library_id, status)
                                            VALUES  (:ISBN, :Copy_Num,:rack_number, :library_id, :status);");
        $statement->bindValue(':ISBN', $book['ISBN']);
        $statement->bindValue(':Copy_Num', $Copy_Num);
        $statement->bindValue(':rack_number', $rack_number);
        $statement->bindValue(':library_id', $library);
        $statement->bindValue(':status', $status);
        $statement->execute();

        $checkAuthors = $_POST['checkAuthors'] ?? null;
        if(!empty($checkAuthors)) {
            $n = count($checkAuthors);
            for($i=0; $i < $n; $i++)
            {
              $statement = $pdo->prepare("INSERT INTO written_by  (ISBN, author_id)
                                                            VALUES  (:ISBN, :author_id);");
              $statement->bindValue(':ISBN', $book['ISBN']);
              $statement->bindValue(':author_id', $checkAuthors[$i]);
              $statement->execute();
            }
        } 

        $checkCategories = $_POST['checkCategories'] ?? null;
        if(!empty($checkCategories)) {
            $n = count($checkCategories);
            for($i=0; $i < $n; $i++)
            {
              $statement = $pdo->prepare("INSERT INTO categorize_as  (ISBN, subject_id)
                                                            VALUES  (:ISBN, :subject_id);");
              $statement->bindValue(':ISBN', $book['ISBN']);
              $statement->bindValue(':subject_id', $checkCategories[$i]);
              $statement->execute();
            }
        } 
        
      
        header('Location: Library_books.php');
    }
?>
         <div class="col-10   pe-5 rounded pt-5 mt-5" style="text-align: justify;">
             <div>
                    <h3 class="green  ps-1 pb-1 rounded-pill ps-3" style="" >Add New Book</h3>
            </div>

            <div class=" overflow-auto container-fluid">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group ">
                        <!-- <label for="formFile" class="form-label mt-4">Uplode Book Image</label> -->
                        <h5 class="mt-4 ps-2">Uplode Book Image</h5>
                        <input class="form-control rounded-pill" type="text" name="image">
                    </div>

                    <div class="form-group">
                        <fieldset >
                        <!-- <label class="form-label" >Title</label> -->
                        <h5 class="mt-4 ps-2">Title</h5>
                        <input class="form-control rounded-pill" name="title" type="text" value="" >
                        </fieldset>
                    </div>

                    <div class="d-flex gap-3">
                        <div class="form-group w-100">
                            <fieldset >
                                <!-- <label class="form-label ps-2" for="disabledInput">Published Year</label> -->
                                <h5 class="mt-4 ps-2">Published Year</h5>
                                <input class="form-control rounded-pill" name="publish_year" type="text" placeholder="" >
                            </fieldset>
                        </div>
    
                        <div class="form-group w-100">
                            <fieldset >
                                <!-- <label class="form-label ps-2" for="disabledInput">Published Month</label> -->
                                <h5 class="mt-4 ps-2">Published Month</h5>
                                <input class="form-control rounded-pill" name="publish_month" type="text" placeholder="" >
                            </fieldset>
                        </div>

                        <div class="form-group w-100">
                            <fieldset >
                                <!-- <label class="form-label ps-2" for="disabledInput">Rack Number</label> -->
                                <h5 class="mt-4 ps-2">Rack Number</h5>
                                <input class="form-control rounded-pill" name="rack_number" type="text" placeholder="" >
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <fieldset class="form-group">
                                <legend class="mt-4">Authors</legend>
                                <?php foreach ($authors as $i => $author) { ?>
                                    <div class="form-check">
                                      <input class="form-check-input rounded-pill" type="checkbox" name="checkAuthors[]" value="<?php echo $author['author_id'] ?>" >
                                      <label class="form-check-label" >
                                        <?php echo $author['fname'] . " " . $author['mname'] . " " . $author['lname']?>
                                      </label>
                                    </div>
                                <?php } ?>
                            </fieldset>
                        </div>

                        <div class="col-6">
                            <fieldset class="form-group">
                                <legend class="mt-4">Categories</legend>
                                <?php foreach ($Categories as $i => $Category) { ?>
                                    <div class="form-check">
                                      <input class="form-check-input rounded-pill" type="checkbox" name="checkCategories[]" value="<?php echo $Category['subject_id'] ?>" >
                                      <label class="form-check-label" >
                                        <?php echo $Category['name'] ?>
                                      </label>
                                    </div>
                                <?php } ?>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <legend class="mt-4">From Library</legend>
                            <?php foreach ($libraries as $i => $library) { ?>
                                <div>
                                    <input type="radio" name="radioLibrary" value="<?php echo $library['library_id']?>" class="radio rounded-pill" /> <?php echo $library['name']?>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-6" >
                            <legend class="mt-4">Publisher</legend>
                            <?php foreach ($publishers as $i => $publisher) { ?>
                                <div>
                                    <input type="radio" name="radioPublisher" value="<?php echo $publisher['publisher_id']?>" class="radio rounded-pill" /> <?php echo $publisher['name']?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    


                    <div class="d-flex gap-2 justify-content-end mt-3">
                        <a class="rounded-pill btn btn-outline-secondary " href="Library_books.php">Cancel, back to Library_books</a>
                        <button type="submit" class="rounded-pill btn btn-outline-success">Add</button>
                    </div>
                </form>
            </div>
        </div>


<?php require_once "parts/footer.php"?>