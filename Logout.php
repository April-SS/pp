<?php
        session_unset();
        session_destroy();
        header('Location: Log_in.php');
?>