<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $statement = $pdo->prepare('SELECT * FROM reserve');
    $statement->execute();
    $reservetions = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-10  pe-5 rounded pt-5 mt-5" style="text-align: justify;">
    <div class="">
        <h3 class="green ps-1 pb-1 rounded-pill ps-3" style="" >Check_out Books</h3>
    </div>

    <div class=" pt-4  overflow-auto container-fluid">

        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">Name</th>
                    <th scope="col">Title</th>
                    <th scope="col">Start_date</th>
                    <th scope="col">End_date</th>
                    <th scope="col">Action</th>
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

                        if(!$returned){
                        ?>
                            <tr>
                                <th scope="row"><?php echo $i + 1 ?></th>
    
                                <td><?php echo $person['email'] ?></td>
                                <td><?php echo $person['fname'] . " " . $person['mname'] ?></td>
                                <td><?php echo $book['title'] ?></td>
                                <td><?php echo $reserve['reserve_date'] ?></td>
                                <td><?php echo $reserve['expecting_reserve_date'] ?></td>
                                <td class="d-flex gap-2">
                                    <?php if(!$reserve['check_out_date']){ ?>
                                        <div>
                                            <form method="post" action="Check_out.php?order_id=<?php echo $reserve['order_id']?>" >
                                                    <button type="submit" class=" btn btn-outline-success">Check_out</button>
                                            </form>
                                        </div>
                                        <div>
                                            <form method="post" action="Deny.php?order_id=<?php echo $reserve['order_id']?>&barcode=<?php echo $book['barcode'] ?>" >
                                                    <button type="submit" class="btn btn-outline-danger">Deny</button>
                                            </form>
                                        </div>
                                    <?php }else { ?>
                                        <div>
                                            <form method="post" action="Return.php?order_id=<?php echo $reserve['order_id']?>&barcode=<?php echo $book['barcode'] ?>" >
                                                    <button type="submit" class=" btn btn-outline-success">Return</button>
                                            </form>
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        

    </div>
</div>


<?php require_once "parts/footer.php"?>