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
    // echo '<pre>';
    // var_dump($book);
    // echo '</pre>';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $start_date = date('Y-m-d');

        $end_date = $_POST['radioEndDate'];
        if ( !$end_date || !$start_date) {
            header('Location: Library_books.php');
            exit;
        }


        switch ($end_date){
            case 0 :
                $end_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + 7 days'));
                break;
            case 1 :
                $end_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + 14 days'));
                break;
            case 2 :
                $end_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + 30 days'));
                break;
            case 3 :
                $end_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + 60 days'));
                break;
            case 4 :
                $end_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + 90 days'));
                break;
        }
       

        

        $statement = $pdo->prepare("INSERT INTO order_  (user_id_member) VALUES  (:user_id_member);");
        $statement->bindValue(':user_id_member', $_SESSION['user_id']);
        $statement->execute();

        $statement = $pdo->prepare('SELECT MAX(order_id) AS order_id FROM order_ WHERE user_id_member = :user_id_member');
        $statement->bindValue(':user_id_member', $_SESSION['user_id']);
        $statement->execute();
        $order_id = $statement->fetch(PDO::FETCH_ASSOC);


    // echo '<pre>';
    // var_dump($order_id);
    // echo '</pre>';
    // exit;
        $statement = $pdo->prepare("INSERT INTO reserve (barcode, order_id, reserve_date, expecting_reserve_date) 
                                                VALUES  (:barcode, :order_id , :reserve_date, :expecting_reserve_date);");
        $statement->bindValue(':barcode', $barcode);
        $statement->bindValue(':order_id', $order_id['order_id']);
        $statement->bindValue(':reserve_date', $start_date);
        $statement->bindValue(':expecting_reserve_date', $end_date);
        $statement->execute();

        $status = 'Not Available';

        $statement = $pdo->prepare("UPDATE book_item SET status = :status WHERE barcode = :barcode");
        $statement->bindValue(':status', $status);
        $statement->bindValue(':barcode', $barcode);
    
        $statement->execute();
        

      
        header('Location: Library_books.php ');
    }
?>

<div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
    <div class="">
        <h3 class="green ps-1 pb-1 rounded-pill ps-3" style="" >Reserve Book</h3>
    </div>

    <div class="pt-4 overflow-auto container-fluid">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="pt-3">
                <strong> <h3>Reserve <?php echo $book['title'] . " -- Copy : " . $book['Copy_Num']?></strong></h3>  
            </div>
    
 
            <div class="col-6 form-group pt-3">
                <fieldset >
                <div class=""><h3 class="form-label ps-2" for="disabledInput"><strong>From</strong></h3></div>
                <input class="form-control rounded-pill" name="start_date" type="text" value="<?php echo date('Y-m-d')?>" disabled="">
                </fieldset>
            </div>     

            <div class="col-6 pt-3 ps-2">   
                    <div class=""><h3 class="form-label ps-2" for="disabledInput"><strong>To</strong></h3></div>     
                    <div class="ps-5">
                        <input type="radio" name="radioEndDate" value="0" class="radio rounded-pill" /> a week
                    </div>
                    <div class="ps-5">
                        <input type="radio" name="radioEndDate" value="1" class="radio rounded-pill" /> 2 week
                    </div>
                    <div class="ps-5">
                        <input type="radio" name="radioEndDate" value="2" class="radio rounded-pill" /> a month
                    </div>
                    <div class="ps-5">
                        <input type="radio" name="radioEndDate" value="3" class="radio rounded-pill" /> 2 month
                    </div>
                    <div class="ps-5">
                        <input type="radio" name="radioEndDate" value="4" class="radio rounded-pill" /> 3 month
                    </div>
                </div>

            <div class="d-flex gap-2 justify-content-end mt-3 pe-2">
                <a class="rounded-pill btn btn-outline-secondary " href="Library_books.php">Cancel, back to Library_books</a>
                <button type="submit" class="rounded-pill btn btn-outline-success">Reserve</button>
            </div>
        </form>
    </div>
</div>


<?php require_once "parts/footer.php"?>