<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $statement = $pdo->prepare('SELECT * FROM libraries');
    $statement->execute();
    $libraries = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
        <div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >Libraries</h3>
            </div>

            <div class=" overflow-auto container-fluid">
                <div class="d-flex justify-content-end mt-4 mb-3">
                <a href="Add_Library.php" class="btn btn-success rounded-pill">Add a Library</a>
                </div>

                <!-- <div>
                    <form action="" method="post" class=" gap-2 mt-2">
                    <div>
                        <h5 for="exampleSelect1" class="form-label mt-1">Search_by_Email_only</h6>
                    </div>
                        <div class="input-group mb-3 gap-1 ">
                            <input type="text" name="search" class="form-control rounded" placeholder="Search" value="<?php // echo $keyword ?>">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                div up for search -->
                <!-- div down for table -->
                <div>
                <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Email</th>
                        <th scope="col">Name</th>
                        <th scope="col">Location</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($libraries as $i => $library) { ?>
                            <tr>
                                <th scope="row"><?php echo $i + 1 ?></th>
    
                                <td><?php echo $library['email'] ?></td>
                                <td><?php echo $library['name'] ?></td>
                                <td><?php echo $library['location'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
                </div>
            </div>
        </div>


<?php require_once "parts/footer.php"?>