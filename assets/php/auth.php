<?php
    include_once('/assets/env/config.php');
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    $users = $auth_login;
    $pass = $auth_passwd;
    
    if(isset($_POST['submit'])){
       // if(!empty($_POST['folder'])){
        //    $conn_id = ftp_connect($resource_path);
        //    $login_result = ftp_login($conn_id, $login_ftp, $passwd_ftp);
         //   ftp_pasv($conn_id, true);
            
               if($users == $_POST['user'] and $pass == $_POST['pass']){
               //     $contents = ftp_rawlist($conn_id, '.');
                 /*   $items = array();
                    foreach ($contents as $row) {
                    	$chunks = preg_split("/\s+/", $row);
                    	if($chunks[0][0] == 'd'){
                        	switch ($_POST['folder']) {
                                case '.':
                                    $_SESSION['auth'] = null;
                                    header("Location: /index.html?param=errorKey");
                                    exit;
                                    break;
                                case '..':
                                    $_SESSION['auth'] = null;
                                    header("Location: /index.html?param=errorKey");
                                    exit;
                                    break;
                                default:
                                    if($_POST['folder'] == $chunks[8]){
                                        $_SESSION['auth'] = $users;
                                        header("Location: /assets/php/index.php?folder=".$_POST['folder']);
                                        exit;
                                    }
                                    break;
                            }
                        } 
                    }*/
                   // $_SESSION['auth'] = null;
                   // header("Location: /index.html?param=errorKey");
                   // exit;
                   $_SESSION['auth'] = $users;
         header("Location: /assets/php/index.php");
         exit;
                } else {
                     $_SESSION['auth'] = null;
                     header("Location: /index.html?param=error");
                     exit;
                } 
       // }
    }
?> 