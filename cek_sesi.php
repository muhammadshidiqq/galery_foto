<?php
    session_start();
    if(!isset($_SESSION['userid'])){
        header("location:masuk.php");
    }
?>