<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

    $title = $_GET['title'];

?>
        <div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-pill ps-3 ps-1 pb-1 " style="" >Main Page</h3>
            </div>

            <div class="overflow-auto container-fluid">
            <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group ">
                        <h2 class="mt-4 ps-2">Issue in <?php echo $title ?> Book</h2>
                    </div>

                    <div class="form-group">
                        <fieldset >
                        <h5 class="mt-4 ps-2">Issue Title</h5>
                        <input class="form-control rounded-pill" name="title" type="text" value="" >
                        </fieldset>
                    </div>

                    
                    <div class="form-group w-100">
                        <fieldset >
                            <h5 class="mt-4 ps-2">Issue Message</h5>
                            <textarea  class="form-control rounded" name="publish_year" type="text" placeholder="" ></textarea >
                        </fieldset>
                    </div>
    
                        
                    <div class="d-flex gap-2 justify-content-end mt-3 pt-3">
                        <a class="rounded-pill btn btn-outline-secondary " href="Reserved_books.php">Cancel, back to Reserved_books</a>
                        <button type="submit" class="rounded-pill btn btn-outline-success">Issue</button>
                    </div>
                </form>
            </div>
        </div>


<?php require_once "parts/footer.php"?>