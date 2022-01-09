<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $ISBN = $_GET['ISBN'];
    $barcode = $_GET['barcode'];

    $statement = $pdo->prepare('SELECT * FROM book WHERE ISBN = :ISBN');
    $statement->bindValue(':ISBN', $ISBN);
    $statement->execute();
    $book = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM publisher');
    $statement->execute();
    $publishers = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM author');
    $statement->execute();
    $authors = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM `written_by` WHERE ISBN = :ISBN');
    $statement->bindValue(':ISBN', $ISBN);
    $statement->execute();
    $writtens = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM `subject_category`');
    $statement->execute();
    $Categories = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM `categorize_as` WHERE ISBN = :ISBN');
    $statement->bindValue(':ISBN', $ISBN);
    $statement->execute();
    $categorizes_as = $statement->fetchAll(PDO::FETCH_ASSOC);

    function checkAuthor($author_id, $list)
    {
        for ($i=0; $i < count($list); $i++) { 
            if($list[$i]["author_id"]== $author_id){
                return true;
            }
        }
        return false;
    }

    function checkCategory($subject_id, $list)
    {
        for ($i=0; $i < count($list); $i++) { 
            if($list[$i]["subject_id"]== $subject_id){
                return true;
            }
        }
        return false;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $image = $_POST['image'] ?? "null";
        $title = $_POST['title'];
        $year = $_POST['publish_year'];
        $month = $_POST['publish_month'];
        $publisher = $_POST['radioPublisher'];

        if (!$title || !$year || !$month || !$publisher) {
            $h = "Location: Book_details.php?ISBN=". $ISBN;
            header($h);
            exit;
        }

        $statement = $pdo->prepare("UPDATE book SET image = :image, 
                                                    title = :title, 
                                                    publish_year = :publish_year,
                                                    publish_month = :publish_month,
                                                    publisher_id = :publisher_id WHERE ISBN = :ISBN");
        $statement->bindValue(':image', $image);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':publish_year', $year);
        $statement->bindValue(':publish_month', $month);
        $statement->bindValue(':publisher_id', $publisher);
        $statement->bindValue(':ISBN', $ISBN);
        $statement->execute();

        $checkAuthors = $_POST['checkAuthors'] ?? null;
        
        $statement = $pdo->prepare('DELETE FROM written_by WHERE ISBN = :ISBN;');
        $statement->bindValue(':ISBN', $ISBN);
        $statement->execute();

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

        $statement = $pdo->prepare('DELETE FROM categorize_as WHERE ISBN = :ISBN;');
        $statement->bindValue(':ISBN', $ISBN);
        $statement->execute();

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
        

        $h = "Location: Book_details.php?ISBN=". $ISBN;
        header($h);
        
    
    }

?>
        <div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >Edit book</h3>
            </div>

            <div class=" overflow-auto container-fluid">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group ">
                        <label for="formFile" class="form-label mt-4 ps-2">Uplode Book Image</label>
                        <input class="form-control rounded-pill " type="text" name="image" value="<?php echo $book['image'] ?>">
                    </div>

                    <div class="form-group">
                        <fieldset >
                        <label class="form-label ps-2 pt-2" >Title</label>
                        <input class="form-control rounded-pill " name="title" type="text" value="<?php echo $book['title'] ?>" >
                        </fieldset>
                    </div>

                    <div class="d-flex gap-3 pt-2">
                        <div class="form-group w-100">
                            <fieldset >
                                <label class="form-label ps-2" for="disabledInput">Published Year</label>
                                <input class="form-control rounded-pill " name="publish_year" type="text" value="<?php echo $book['publish_year'] ?>" >
                            </fieldset>
                        </div>
    
                        <div class="form-group w-100">
                            <fieldset >
                                <label class="form-label ps-2" for="disabledInput">Published Month</label>
                                <input class="form-control rounded-pill" name="publish_month" type="text" value="<?php echo $book['publish_month'] ?>" >
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <fieldset class="form-group">
                                <legend class="mt-4">Authors</legend>
                                <?php foreach ($authors as $i => $author) { ?>
                                    <div class="form-check">
                                      <input class="form-check-input rounded-pill" type="checkbox" name="checkAuthors[]" value="<?php echo $author['author_id'] ?>"  <?php if(checkAuthor($author['author_id'], $writtens)) echo 'checked' ?>>
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
                                      <input class="form-check-input rounded-pill" type="checkbox" name="checkCategories[]" value="<?php echo $Category['subject_id'] ?>" <?php if(checkCategory($Category['subject_id'], $categorizes_as)) echo 'checked' ?> >
                                      <label class="form-check-label" >
                                        <?php echo $Category['name'] ?>
                                      </label>
                                    </div>
                                <?php } ?>
                            </fieldset>
                        </div>
                    </div>

                    <div class="" >
                        <legend class="mt-4">Publisher</legend>
                        <?php foreach ($publishers as $i => $publisher) { ?>
                            <div>
                                <input type="radio" name="radioPublisher" value="<?php echo $publisher['publisher_id']?>" class="radio" <?php if($book['publisher_id'] == $publisher['publisher_id']) echo 'checked' ?>/> <?php echo $publisher['name']?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-3">
                        <a class="rounded-pill btn btn-outline-secondary " href="Book_details.php?barcode=<?php echo $barcode?>">Cancel</a>
                        <button type="submit" class="rounded-pill btn btn-outline-success">Edit</button>
                    </div>
                </form>
            </div>
        </div>


<?php require_once "parts/footer.php"?>