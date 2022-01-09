
        <div class="col-2  pt-5  " style=" background-color: rgb(8, 53, 39); height: 1800px" >
            <a href="Member_Main.php" class="btn btn-block text-start rounded-top rounded-0 green " ><h6>Main Page</h6></a>
            <a href="Library_books.php" class="btn btn-block text-start rounded-0 green" ><h6>Library Books</h6></a>
            <a href="Reserved_books.php" class="btn btn-block text-start rounded-0 green" ><h6>Reserved Books</h6></a>
            <a href="#" class="btn btn-block text-start rounded-0 green" ><h6>WaitList Books</h6></a>
            <a href="#" class="btn btn-block text-start rounded-0 rounded-bottom green" ><h6>Issued Books</h6></a>
            <?php if($user['user_type'] == "Librarian"){?>
                <a href="All_Members.php" class="btn btn-block text-start rounded-top rounded-0 green mt-2" ><h6>All Members</h6></a>
                <a href="All_Authors.php" class="btn btn-block text-start rounded-0 green" ><h6>All Authors</h6></a>
                <a href="Libraries.php" class="btn btn-block text-start rounded-0 green" ><h6>Libraries</h6></a>
                <a href="Publishers.php" class="btn btn-block text-start rounded-0 green" ><h6>Publishers</h6></a>
                <a href="Subject_Categories.php" class="btn btn-block text-start rounded-0 green" ><h6>Subject Categories</h6></a>
                <a href="Check_Out_Librarian.php" class="btn btn-block text-start rounded-0 green" ><h6>Check_Out books</h6></a>
                <a href="Request_books.php" class="btn btn-block text-start rounded-0 green" ><h6>Request Book</h6></a>
                <a href="Canceled_Members.php" class="btn btn-block text-start rounded-0 rounded-bottom green" ><h6>Canceled Members</h6></a>
            <?php } ?>
            <a href="Logout.php" class="btn btn-block text-start rounded mt-2 green"><h6>Logout</h6></a>
        </div>
        
