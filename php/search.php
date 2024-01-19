<?php
/**
 * Perform users searching process
 */
    session_start();
    include_once "config.php";

    // get the searchTerm and the id of the user that is performing the search
    $outgoing_id = $_SESSION['unique_id'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

    // get the users that are not the user who is performing the search
    $getOtherUsers = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') ";
    $output = "";
    // $query = number of other users
    $query = mysqli_query($conn, $getOtherUsers);
    // if found
    if (mysqli_num_rows($query) > 0) {
        include_once "data.php"; // import data.php
    } else {
        $output .= 'No user found related to your search term';
    }
    echo $output;
?>