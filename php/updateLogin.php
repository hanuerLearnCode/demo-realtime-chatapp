<?php

    // Model ?? 

    session_start();
    include_once "config.php";

    // 
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // get the submitted data
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $errorText="";

    /**
     * validation
     */
    // check email
    if (empty($email) || empty($password)) {
        exit("All input fields are required");
    }

    $getUserWhoseEmail = mysqli_query($conn, "SELECT * FROM users where email = '{$email}'");
    $numberOfReturnedUsers = mysqli_num_rows($getUserWhoseEmail);

    if ($numberOfReturnedUsers < 1) {
        $errorText = "$email - This email does not exist";
        exit($errorText);
    }
    
    // check password
    $userArray = mysqli_fetch_assoc($getUserWhoseEmail);
    $userPassword = md5($password);
    $returnedPassword = $userArray['password'];

    if ($userPassword != $returnedPassword) {
        $errorText = "Email or Password is Incorrect";
        exit($errorText);
    }
    
    // update user status in the db
    $status = "Active now";
    $updateStatus = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = '{$userArray['unique_id']}'");

    if (!($updateStatus)) {
        $errorText = "Something went wrong. Please try again!";
        exit($errorText);
    }

    $_SESSION['unique_id'] = $userArray['unique_id'];
    echo "success"; // xhr.response - somehow this shit is not working? 
    // header("Location: ../views/users.php");
?>