<?php 
    require_once "parts/header.php";
    require_once "parts/menu.php";

?>
        <div class="col-10 pe-5 rounded pt-5 mt-5" style="text-align: justify;">
            <div>
                    <h3 class="green rounded-top ps-1 pb-1 " style="" >Main Page</h3>
            </div>

            <div class="overflow-auto container-fluid">
            <h3>Hellow <?php echo $user['fname'];echo " "; echo $user['mname']?>,</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni autem dolores quam suscipit perspiciatis molestiae non dolor quidem eveniet ut.</p>
            </div>
        </div>


<?php require_once "parts/footer.php"?>