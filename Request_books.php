<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $statement = $pdo->prepare('SELECT * FROM request');
    $statement->execute();
    $Requests = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
        <div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-1 pb-1 ps-3" style="" >Requested Books</h3>
            </div>

            <div class=" overflow-auto container-fluid">

                <div class="mt-2 d-flex justify-content-end mt-5">
                    <?php if($user['user_type'] == "Librarian"){?>
                        <a href="Request_book.php" class="btn btn-success rounded-pill">Request A Book</a>
                    <?php } ?>
                </div>

                <!-- <div>
                    <h5 for="exampleSelect1" class="form-label mt-1">Search by</h6>
                </div>


                <form action="" method="post" class="d-flex gap-2 ">
                    <div class="form-group  ">
                        <select class="form-select" name="search_type" aria-label=".form-select-sm example">
                            <option selected>Select Type option</option>
                            <option value="1">Title</option>
                            <option value="2">Author</option>
                            <option value="3">Subject</option>
                            <option value="4">Publication date (as year xxxx)</option>
                        </select>
                    </div>
                    <div class="input-group mb-3 gap-1 ">
                        <input type="text" name="search" class="form-control rounded" placeholder="Search" value="<?php echo $keyword ?>">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">Search</button>
                        </div>
                    </div>
                </form> -->


                <!-- div up for search -->
                <!-- div down for table -->
                <div class="mt-2">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Start_date</th>
                        <th scope="col">End_date</th>
                        <th scope="col">Cost</th>
                        <th scope="col">From Library</th>
                        <th scope="col">Requested By</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($Requests as $i => $Request) { 

                         $statement = $pdo->prepare('SELECT * FROM person WHERE user_id = :user_id');
                         $statement->bindValue(':user_id', $Request['user_id_librarian']);
                         $statement->execute();
                         $librarian = $statement->fetch(PDO::FETCH_ASSOC);

                         $statement = $pdo->prepare('SELECT * FROM libraries WHERE library_id = :library_id');
                         $statement->bindValue(':library_id', $Request['library_id']);
                         $statement->execute();
                         $library = $statement->fetch(PDO::FETCH_ASSOC);
                        
                         if($Request['end_loan_date'] < date('Y-m-d') || $Request['start_loan_date'] > $Request['end_loan_date'] ) {
                            $statement = $pdo->prepare('DELETE FROM request WHERE title = :title');
                            $statement->bindValue(':title', $Request['title']);
                            $statement->execute();
                            header('Location: Request_books.php');
                            exit;
                         }

                         

                        ?>
                        <tr>
                            <th scope="row"><?php echo $i + 1 ?></th>
                            <td class = "align-middle"><?php echo $Request['title'] ?></td>
                            <td class = "align-middle"><?php echo $Request['start_loan_date']?></td>
                            <td class = "align-middle"><?php echo $Request['end_loan_date'] ?></td>
                            <td class = "align-middle"><?php echo $Request['cost'] ?></td>
                            <td class = "align-middle"><?php echo $library['name']?></td>
                            <td class = "align-middle"><?php echo $librarian['fname'] . " " . $librarian['mname'] ?></td>
                            <td class = "align-middle"><?php echo 'Waiting'?></td>
                            
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php// echo date('Y-m-d', strtotime(date('Y-m-d'). ' + 5 days'));?>
                </div>
            </div>
        </div>


<?php require_once "parts/footer.php"?>