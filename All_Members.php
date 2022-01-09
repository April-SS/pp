<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $keyword = $_POST['search'] ?? "";

    if ($keyword) {
        $statement = $pdo->prepare('SELECT * FROM person WHERE email like :keyword');
        $statement->bindValue(":keyword", "%$keyword%");
    }else
        $statement = $pdo->prepare('SELECT * FROM person ');
    

    $statement->execute();
    $members = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM cancel_member WHERE user_id = :user_id');
    $statement->bindValue(':user_id', $user['user_id']);
    $statement->execute();
    $check = $statement->fetch(PDO::FETCH_ASSOC);

?>
        <div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >All Members</h3>
            </div>

            <div class=" content overflow-auto pe-2 container-fluid">
                <!-- for add new member -->
                <div class="d-flex justify-content-end ">
                <a href="Register.php" class="btn btn-success rounded-pill">Register new Account</a>
                </div>

                <div>
                    <form action="" method="post" class=" gap-2 mt-2">
                    <div>
                        <h5 for="exampleSelect1" class="form-label mt-1 ps-2">Search_by_Email_only</h6>
                    </div>
                        <div class="input-group mb-3 gap-2 ">
                            <input type="text" name="search" class="form-control rounded-pill" placeholder="Search" value="<?php echo $keyword ?>">
                            <div class="input-group-append">
                                <button class="btn btn-success rounded-pill" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- div up for search -->
                <!-- div down for table -->
                <div>
                <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Email</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Middle Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">User Type</th>
                        <th scope="col">Registered by</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $i => $member) { 
                            
                            $statement = $pdo->prepare('SELECT * FROM cancel_member WHERE user_id = :user_id');
                            $statement->bindValue(':user_id', $member['user_id']);
                            $statement->execute();
                            $check = $statement->fetch(PDO::FETCH_ASSOC);

                            $statement = $pdo->prepare('SELECT p.*
                            FROM person p JOIN register_member c ON p.user_id = c.user_id_librarian
                            WHERE c.user_id = :user_id; ');
                            $statement->bindValue(':user_id', $member['user_id']);
                            $statement->execute();
                            $whoLibrarian = $statement->fetch(PDO::FETCH_ASSOC) ?? 0;
                        
                        
                        ?>
                            <tr>
                                <th scope="row"><?php echo $i + 1 ?></th>
    
                                <td><?php echo $member['email'] ?></td>
                                <td><?php echo $member['fname'] ?></td>
                                <td><?php echo $member['mname'] ?></td>
                                <td><?php echo $member['lname'] ?></td>
                                <td><?php echo $member['gender'] ?></td>
                                <td><?php echo $member['phone_number'] ?></td>
                                <td><?php echo $member['user_type'] ?></td>
                                <td><?php if(!$whoLibrarian)
                                            echo "NULL";
                                          else
                                            echo $whoLibrarian['fname'] . " " . $whoLibrarian['mname'] ?></td>
                                
                                <td >
                                    <a href="Profile.php?user_id=<?php echo $member['user_id']?>" class="btn btn-sm btn-outline-primary">Details</a>
                                    <form method="post" action="Cancel_Membership.php" style="display: inline-block"  >
                                        <input  type="hidden" name="user_id" value="<?php echo $member['user_id'] ?>"/>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" <?php if($check || $member['user_id'] == $_SESSION['user_id'] )echo 'disabled' ?>>Cancel Membership</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
                </div>
            </div>
        </div>


<?php require_once "parts/footer.php"?>