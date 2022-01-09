<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $statement = $pdo->prepare('SELECT r.* FROM reserve r, order_ o, member m WHERE m.user_id_member = :user_id AND m.user_id_member = o.user_id_member AND o.order_id = r.order_id;');
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->execute();
    $reservetions = $statement->fetchAll(PDO::FETCH_ASSOC);
    
?>

<div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
    <div class="">
        <h3 class="green ps-1 pb-1 rounded-pill ps-3" style="" >Reserved books</h3>
    </div>

    <div class="pt-4 overflow-auto container-fluid">

        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Start_date</th>
                    <th scope="col">End_date</th>
                    <th scope="col">Checked_Out</th>
                    <th scope="col">Returned</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservetions as $i => $reserve) { 
                        
                        $statement = $pdo->prepare('SELECT b.*, i.* FROM book b JOIN book_item i ON b.ISBN = i.ISBN WHERE barcode = :barcode');
                        $statement->bindValue(':barcode', $reserve['barcode']);
                        $statement->execute();
                        $book = $statement->fetch(PDO::FETCH_ASSOC);

                        $statement = $pdo->prepare('SELECT user_id_member FROM order_ o JOIN reserve r WHERE o.order_id = :order_id;');
                        $statement->bindValue(':order_id', $reserve['order_id']);
                        $statement->execute();
                        $user_id = $statement->fetch(PDO::FETCH_ASSOC);

                        $statement = $pdo->prepare('SELECT p.* FROM person p JOIN member m ON p.user_id = m.user_id_member WHERE m.user_id_member = :user_id;');
                        $statement->bindValue(':user_id', $user_id['user_id_member']);
                        $statement->execute();
                        $person = $statement->fetch(PDO::FETCH_ASSOC);

                        $statement = $pdo->prepare('SELECT * FROM return_book WHERE order_id = :order_id');
                        $statement->bindValue(':order_id', $reserve['order_id']);
                        $statement->execute();
                        $returned = $statement->fetch(PDO::FETCH_ASSOC);

                        
                        ?>
                            <tr>
                                <th scope="row"><?php echo $i + 1 ?></th>
    
                                <td><?php echo $book['title'] ?></td>
                                <td><?php echo $reserve['reserve_date'] ?></td>
                                <td><?php echo $reserve['expecting_reserve_date'] ?></td>
                                <td><?php if($reserve['check_out_date']){echo 'Yes';} else{echo 'No';} ?></td>
                                <td>
                                    <?php if($returned){ ?>
                                        <div class="d-flex gap-4">
                                            <div>
                                                Yes
                                            </div>
                                            <div>
                                                <a class=" btn btn-outline-success w-30 " href="Report_issue.php?title=<?php echo $book['title']?>">Report an issue</a>
                                            </div>
                                        </div>
                                    <?php } else{echo 'No';} ?>
                                </td>
                                
                            </tr>
                        
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>


<?php require_once "parts/footer.php"?>