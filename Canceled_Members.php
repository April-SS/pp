<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    // $statement = $pdo->prepare('SELECT * FROM libraries');
    // $statement->execute();
    // $libraries = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT p.* FROM person p JOIN cancel_member c ON p.user_id=c.user_id; ');
    $statement->execute();
    $members = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_POST['user_id'] ?? null;

        if (!$user_id) {
            header('Location: Canceled_Members.php');
            exit;
        }
        
        $statement = $pdo->prepare('DELETE FROM cancel_member WHERE user_id = :user_id;');
                
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        header('Location: Canceled_Members.php');
    }
?>
        <div class="col-10  pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >Canceled Members</h3>
            </div>

            <div class=" pt-3 overflow-auto container-fluid">
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
                        <th scope="col">Canceled by</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $i => $member) { 
                            
                            

                            $statement = $pdo->prepare('SELECT p.*
                                                        FROM person p JOIN cancel_member c ON p.user_id = c.user_id_librarian
                                                        WHERE c.user_id = :user_id; ');
                            $statement->bindValue(':user_id', $member['user_id']);
                            $statement->execute();
                            $whoLibrarian = $statement->fetch(PDO::FETCH_ASSOC);
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
                                <td><?php echo $whoLibrarian['fname'] . " " . $whoLibrarian['mname'] ?></td>
                                
                                <td >
                                    <form method="post" action="" style="display: inline-block"  >
                                        <input  type="hidden" name="user_id" value="<?php echo $member['user_id'] ?>"/>
                                        <button type="submit" class="btn btn-sm btn-outline-success">Activate Membership</button>
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