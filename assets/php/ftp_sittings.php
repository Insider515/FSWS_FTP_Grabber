<?php
session_start();
include_once('/assets/env/config.php');
    if($_SESSION['auth'] != $auth_login){
        header("Location: /index.php");    
        exit; 
    }  ?>