<?php

    // $query = $numberOfOtherUsers
    while ($row = mysqli_fetch_assoc($query)) {
        // get all the chat from table messages that satisfies one of these conditions:
        //      the id of receiver = the id of the user that is being searched
        //      the id of the sender = the id of the targeted user && the id of the sender == the id of the user that is searching
        //      the id of the receiver == the id of the user that is searching
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = '{$row['unique_id']}'
                OR outgoing_msg_id = '{$row['unique_id']}') AND (outgoing_msg_id = '{$outgoing_id}' 
                OR incoming_msg_id = '{$outgoing_id}') ORDER BY msg_id DESC LIMIT 1";
        
        // searching in the db
        $query2 = mysqli_query($conn, $sql2);
        // 
        $msgsArray = mysqli_fetch_assoc($query2);

        // if-else condition -> if found any msg, save it to $result, else return no findings
        (mysqli_num_rows($query2) > 0) ? $result = $msgsArray['msg'] : $result ="No message available";
        // limit to only 28 chars are visible in the searchResult box
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
        
        // check if the last msg belong to which users
        if (isset($msgsArray['outgoing_msg_id'])) {
            ($outgoing_id == $msgsArray['outgoing_msg_id']) ? $you = "You: " : $you = "";
        } else {
            $you = "";
        }

        // showing users status
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        // ??
        ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

        // return the output in the user list div
        $output .= '<a href="chat.php?user_id='. $row['unique_id'] .'">
                    <div class="content">
                    <img src="php/images/'. $row['img'] .'" alt="">
                    <div class="details">
                        <span>'. $row['fname']. " " . $row['lname'] .'</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';
    }
?>