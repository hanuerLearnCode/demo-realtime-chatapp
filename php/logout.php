<?php
/**
 * Log out controller
 */
    session_start();
    if(isset($_SESSION['unique_id'])){ // if user has logged in
        include_once "config.php"; // import db connection
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']); // get the logout-id - unique_id in the log out button from the user.php
        if(isset($logout_id)){ // if the button is clicked
            $status = "Offline now"; 
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}"); // update the status
            if($sql){
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
        }else{
            header("location: ../users.php");
        }
    }else{  
        header("location: ../login.php");
    }
?>