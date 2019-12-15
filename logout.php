<?php

    session_start();
    if(isset($_SESSION['NomPrenom']))
    {
        session_unset();

        session_destroy();

        header("location:index.php");
    
    }
    else
    {
        header("location:login.php");
    }
    
?>