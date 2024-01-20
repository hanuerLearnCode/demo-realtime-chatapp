<?php

    session_start();

    if (!(isset($_SESSION['unique_id']))) {
        header("location: ../views/login.php");
    }
    // import db conn
    include_once('config.php');
    // get id of sender and receiver
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);

    $output = "";
    // get msg using user_id
    $getMsgQuery = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
    WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
    OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
    // query the db
    $query = mysqli_query($conn, $sql);

    // if no msg is found
    if (mysqli_num_rows($query) < 1) {
        $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
    }

    // getting chat from db and render to the view
    while ($row = mysqli_fetch_assoc($query)) {
        if ($row['outgoing_msg_id'] === $outgoing_id) {
            $output .= '<div class="chat outgoing">
                        <div class="details">
                            <p>'. $row['msg'] .'</p>
                        </div>
                        </div>';
        }else{
            $output .= '<div class="chat incoming">
                        <img src="../php/images/'.$row['img'].'" alt="">
                        <div class="details">
                            <p>'. $row['msg'] .'</p>
                        </div>
                        </div>';
        }
    }