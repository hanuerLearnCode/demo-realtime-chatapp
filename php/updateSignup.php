<?php
    session_start();
    // importing the db connection
    include_once "config.php";

    // getting the actual data from the form
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    /** validation */

    // if any data is missing
    if (empty($fname) || empty($lname) || empty($email) || empty($password))
    {
        exit("All input fields are required!");
    }

    // check email
    if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) 
    {
        exit("$email is not a valid email");
    } 
    else 
    {
        // checking if email already existed
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if(mysqli_num_rows($sql) > 0)
        {
            exit ("$email - This email already exist!"); // announce fail
        }
    }

    // validate image
    if(isset($_FILES['image'])){
        // get image info
        $img_name = $_FILES['image']['name'];
        $img_type = $_FILES['image']['type'];
        $tmp_name = $_FILES['image']['tmp_name'];
        // split the path of the img
        $img_explode = explode('.',$img_name);
        // get the ending tag - the type - of the img
        $img_ext = end($img_explode);

        // check image extensions
        $extensions = ["jpeg", "png", "jpg"];
        if(in_array($img_ext, $extensions) === false)
        {
            exit("Please upload an image file - jpeg, png, jpg");
        }
        // check img types
        $types = ["image/jpeg", "image/jpg", "image/png"];
        if(in_array($img_type, $types) === false)
        {
            exit("Please upload an image file - jpeg, png, jpg");
        }
    }

    /** after validation */
    // insert data to db
    // select where to store the image
    $time = time();
    $new_img_name = $time.$img_name; // set the name
    // store the img in the php/images
    $flag = move_uploaded_file($tmp_name, "images/".$new_img_name);
    // if failed
    if ($flag === false) {
        exit("Something went wrong. Please try again!");
    }

    // generate data
    $ran_id = rand(time(), 100000000); // unique_id
    $status = "Active now";
    $encrypt_pass = md5($password); // md5 encrypt password
    // insert data to db
    $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
    VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");

    // if success
    if($insert_query) 
    {
        // final check
        $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if(mysqli_num_rows($select_sql2) > 0)
        {
            $result = mysqli_fetch_assoc($select_sql2);
            $_SESSION['unique_id'] = $result['unique_id']; // check if the unique_id is matched
            echo "success";
        }
        else
        {
            echo "This email address not Exist!";
        }
    }