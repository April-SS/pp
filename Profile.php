<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $user_id = $_GET['user_id'] ?? $_SESSION['user_id'];

    $statement = $pdo->prepare('SELECT * FROM person WHERE user_id = :user_id');
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->execute();
    $Log_iner = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM person WHERE user_id = :user_id');
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if($user['user_type'] == 'Librarian'){
        $statement = $pdo->prepare('SELECT * FROM librarian WHERE user_id_librarian = :user_id');
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $librarian = $statement->fetch(PDO::FETCH_ASSOC);
    }

?>

<div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
    <div class="">
        <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" ><?php echo $user['fname']; ?>_Profile</h3>
    </div>

    <div class="overflow-auto container-fluid">

        <div class="row mb-3 pt-2">
            <div class="col-6 form-group">
                <fieldset disabled="">
                <label class="form-label ps-2" for="disabledInput">Email</label>
                <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $user['email']?>" disabled="">
                </fieldset>
            </div>

            <div class="col-6 form-group">
                <fieldset disabled="">
                <label class="form-label ps-2" for="disabledInput">Phone_Number</label>
                <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $user['phone_number']?>" disabled="">
                </fieldset>
            </div>
        </div>

        <div class="row mb-3 ">
            <div class="col-4 form-group">
                <fieldset disabled="">
                <label class="form-label ps-2" for="disabledInput">First_Name</label>
                <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $user['fname']?>" disabled="">
                </fieldset>
            </div>

            <div class="col-4 form-group">
                <fieldset disabled="">
                <label class="form-label ps-2" for="disabledInput">Middle_Name</label>
                <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $user['mname']?>" disabled="">
                </fieldset>
            </div>

            <div class="col-4 form-group">
                <fieldset disabled="">
                <label class="form-label ps-2" for="disabledInput">Last_Name</label>
                <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $user['lname']?>" disabled="">
                </fieldset>
            </div>
        </div>

        <div class="row mb-3 ">
            <div class="col-6 form-group">
                <fieldset disabled="">
                <label class="form-label ps-2" for="disabledInput">You are a</label>
                <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $user['user_type']?>" disabled="">
                </fieldset>
            </div>

            <div class="col-6 form-group">
                <fieldset disabled="">
                <label class="form-label ps-2" for="disabledInput">Gender</label>
                <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $user['gender']?>" disabled="">
                </fieldset>
            </div>
        </div>

        <?php if($user['user_type'] == "Librarian"){?>
            <div class="row mb-3 ">
                <div class="col-6 form-group">
                    <fieldset disabled="">
                    <label class="form-label ps-2" for="disabledInput">Work hours</label>
                    <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $librarian['work_hours']?>" disabled="">
                    </fieldset>
                </div>
    
                <div class="col-6 form-group">
                    <fieldset disabled="">
                    <label class="form-label ps-2" for="disabledInput">Salary</label>
                    <input class="form-control rounded-pill" id="disabledInput" type="text" placeholder="<?php echo $librarian['salary']?>" disabled="">
                    </fieldset>
                </div>
            </div>
        <?php } ?>

        <div class="d-flex gap-2 justify-content-end pt-2">
            <a class="rounded-pill btn btn-outline-success " href="Update_Profile.php?user_id=<?php echo $user['user_id']?>">Edit Profile</a>
            <?php if($Log_iner['user_type'] == "Librarian"){ ?>
                <a class="rounded-pill btn btn-outline-success " href="All_Members.php">Back to All_Members</a>
            <?php } else{ ?>
                <a class="rounded-pill btn btn-outline-success " href="Member_Main.php">Back to Main Page</a>
            <?php } ?>
        </div>

    </div>
</div>



<?php require_once "parts/footer.php"?>