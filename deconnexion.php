<?php 
    session_start();
    echo "hbhbkjbkjbk";
    
    if(isset($_POST['logout'])){
        session_destroy();
        header("Location: connexion.php");
    }
?>