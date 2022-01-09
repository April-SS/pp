<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $statement = $pdo->prepare('SELECT * FROM reserve');
    $statement->execute();
    $reservetions = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($reservetions as $i => $reserve) {
        if(!$reserve['check_out_date'] &&  date('Y-m-d', strtotime($reserve['reserve_date']. ' + 2 days')) < date('Y-m-d')){
            $statement = $pdo->prepare("DELETE FROM reserve WHERE order_id = :order_id;");
            $statement->bindValue(':order_id', $reserve['order_id']);
            $statement->execute();
            
            $statement = $pdo->prepare("DELETE FROM order_ WHERE order_id = :order_id;");
            $statement->bindValue(':order_id', $reserve['order_id']);
            $statement->execute();
            
            $statement = $pdo->prepare("UPDATE book_item SET status = :status WHERE barcode = :barcode");
            $statement->bindValue(':status', 'Available');
            $statement->bindValue(':barcode', $reserve['barcode']);
            $statement->execute();
        }
    }

?>
        <div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div >
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >Main Page</h3>
            </div>

            <div class="  overflow-auto ps-2 pt-2 container-fluid">
            <h3>Hellow <?php echo $user['fname'];echo " "; echo $user['mname']?>,</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni autem dolores quam suscipit perspiciatis molestiae non dolor quidem eveniet ut.</p>
            </div>
        </div>


<?php require_once "parts/footer.php"?>