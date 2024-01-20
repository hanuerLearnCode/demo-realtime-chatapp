<?php

// Log out controller

    session_start();

    if (!isset($_SESSION['unique_id'])) {
        header("location: ../login.php");
    }

    include_once('config.php');

    $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);

    if(!isset($logout_id)) {
        header("location: ../users.php");
    }

    $status = "Offline now";
    $updateStatus = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$_GET['logout_id']}");
    if ($updateStatus) {
        session_unset();
        session_destroy();
        header("location: ../views/login.php");
    }