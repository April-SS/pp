<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $keyword = $_POST['search'] ?? "";
    $option = isset($_POST['search_type']) ? $_POST['search_type'] : 0;

    switch($option){
        case 1:
            $statement = $pdo->prepare('SELECT b.*, i.* FROM book b JOIN book_item i ON b.ISBN = i.ISBN WHERE title like :keyword;');
            $statement->bindValue(":keyword", "%$keyword%");
            break;
        case 2:
            $statement = $pdo->prepare('SELECT DISTINCT b.*, bi.* FROM book b JOIN book_item bi ON b.ISBN = bi.ISBN, author, written_by WHERE author.fname LIKE :keyword AND written_by.author_id = author.author_id AND written_by.ISBN = b.ISBN;');
            $statement->bindValue(":keyword", "%$keyword%");
            break;
        case 3:
            $statement = $pdo->prepare('SELECT DISTINCT b.*, bi.* FROM book b JOIN book_item bi ON b.ISBN = bi.ISBN, subject_category, categorize_as WHERE subject_category.name Like :keyword AND categorize_as.subject_id = subject_category.subject_id AND categorize_as.ISBN = b.ISBN;');
            $statement->bindValue(":keyword", "%$keyword%");
            break;
        case 4:
            $statement = $pdo->prepare('SELECT b.*, i.* FROM book b JOIN book_item i ON b.ISBN = i.ISBN WHERE publish_year like :keyword;');
            $statement->bindValue(":keyword", "%$keyword%");
            break;
        default:
        $statement = $pdo->prepare('SELECT b.*, i.* FROM book b JOIN book_item i ON b.ISBN = i.ISBN; ');
    }
    
    
    $statement->execute();
    $books = $statement->fetchAll(PDO::FETCH_ASSOC);
    sort($books)
?>
        <div class="col-10 pe-5 rounded pt-5 mt-5 " style="text-align: justify;">
            <div class="">
                    <h3 class="green rounded-pill ps-1 pb-1 ps-3" style="" >Library Books</h3>
            </div>

            <div class="content overflow-auto pe-1 container-fluid">

                <div class="mt-2 d-flex justify-content-end">
                    <?php if($user['user_type'] == "Librarian"){?>
                        <a href="Add_Book.php" class="btn btn-success rounded-pill">Add New Book</a>
                    <?php } ?>
                </div>

                <div>
                    <h5 for="exampleSelect1" class="form-label mt-1 ps-4">Search by</h6>
                </div>


                <form action="" method="post" class="d-flex gap-2 ps-3 ">
                    <div class="form-group  ">
                        <select class="form-select rounded-pill " name="search_type" aria-label=".form-select-sm example">
                            <option selected>Select Type option</option>
                            <option value="1">Title</option>
                            <option value="2">Author</option>
                            <option value="3">Subject</option>
                            <option value="4">Publication date (as year xxxx)</option>
                        </select>
                    </div>
                    <div class="input-group mb-3 gap-1 ">
                        <input type="text" name="search" class="form-control rounded-pill" placeholder="Search" value="<?php echo $keyword ?>">
                        <div class="input-group-append">
                            <button class="btn btn-success rounded-pill" type="submit">Search</button>
                        </div>
                    </div>
                </form>


                <!-- div up for search -->
                <!-- div down for table -->
                <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Publication Date</th>
                        <th scope="col">Copy Num#</th>
                        <th scope="col">Available</th>
                        <th scope="col">WaitList#</th>
                        <th scope="col" >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($books as $i => $book) { ?>
                        <tr>
                            <th scope="row"><?php echo $i + 1 ?></th>
                            <td>
                                <?php if ($book['image']): ?>
                                    <img src="<?php echo $book['image'] ?>" alt="<?php echo $book['image'] ?>" style=" width: 50px;">
                                <?php endif; ?>
                            </td>
                            <td class = "align-middle"><?php echo $book['title'] ?></td>
                            <td class = "align-middle"><?php echo $book['publish_year'] . "/" .  $book['publish_month'];?></td>
                            <td class = "align-middle"><?php echo $book['Copy_Num'] ?></td>

                            <!-- status condition -->
                            <?php if($book['status'] == 'Available'){?>
                                <td class = "align-middle" style="color: green;"><?php echo $book['status'] ?></td>
                            <?php } elseif($book['status'] == 'Not Available'){ ?>
                                <td class = "align-middle" style="color: red;"><?php echo $book['status'] ?></td> 
                            <?php } ?>
                                
                                <td class = "align-middle" >wait 1</td>

                            <td class = "align-middle " >
                                <div class="  d-grid " >
                                    <a href="Book_details.php?barcode=<?php echo $book['barcode']?>" class="btn btn-sm btn-outline-secondary">Details</a>
                                    <?php if($book['Copy_Num'] == 1){ ?>
                                    <button type="button" class="btn btn-secondary" disabled>This book only for Reading in Library</button> 
                                    <?php if($user['user_type'] == "Librarian"){?>
                                        <div class="mt-2 d-grid">
                                        <form method="post" action="delete.php" style="display: inline-block">
                                            <input  type="hidden" name="id" value="<?php echo $product['id'] ?>"/>
                                            <a href="Add_BookCopy.php?ISBN=<?php echo $book['ISBN']?>" class="btn btn-sm btn-outline-success w-100">Add a Copy Book</a>
                                        </form>
                                        </div>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <a href="Reserve.php?barcode=<?php echo $book['barcode'] ?>" class="btn btn-sm btn-outline-secondary <?php if($book['status'] == 'Not Available') echo "disabled"?>"  >Reserve</a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary">WaitList</a>
                                        <?php } ?>
                                </div>  
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

<?php require_once "parts/footer.php"?>