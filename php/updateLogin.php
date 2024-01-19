<?php

    // Model ?? 

    session_start();
    include_once "config.php";

    // get the submitted data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    /**
     * validation
     */
    // check email
    if (empty($email) || empty($password)) {
        exit("All input field are required");
    }

    $getUserWhoseEmail = mysqli_query($conn, "SELECT * FROM users where email = '{$email}'");
    $numberOfReturnedUsers = mysqli_num_rows($getUserWhoseEmail);

    if ($numberOfReturnedUsers < 0) {
        exit ("$email - This email does not exist");
    }
    
    // check password
    $userArray = mysqli_fetch_assoc($getUserWhoseEmail);
    $userPassword = md5($password);
    $returnedPassword = $userArray['password'];

    if ($userPassword != $returnedPassword) {
        exit ("Email or Password is Incorrect");
    }
    
    // update user status in the db
    $status = "Active now";
    $updateStatus = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = '{$userArray['unique_id']}'");

    if (!($updateStatus)) {
        exit ("Something went wrong. Please try again!");
    }

    $_SESSION['unique_id'] = $row['unique_id'];
    echo "success"; // xhr.response - somehow this shit is not working? 
    header("Location: users.php");
?>