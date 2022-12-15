<?php 
header('Content-Type: text/html; charset=utf-8');
    if($_POST['submit']) { 
        session_start();
        $_SESSION['auth'] = null;
        session_destroy();
        unset($_SESSION['auth']);
        header("Location: /index.php");    
        exit; 
    } 
?>