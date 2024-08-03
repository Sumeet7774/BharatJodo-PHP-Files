<?php

    require "connection.php";

    $username = $_POST['username'];
    $email_id = $_POST['email_id'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];

    $check_sql = "select * from users where username='$username' or email_id='$email_id' or phone_number='$phone_number' ";
    $check = mysqli_query($conn,$check_sql);

    if(mysqli_num_rows($check))
    {
        echo "User data already exists";
    }
    else
    {
        $query = "insert into users(username,email_id,password,phone_number) VALUES('$username', '$email_id', '$password', '$phone_number') ";

        if(mysqli_query($conn,$query))
        {
            echo "success";
        }
        else
        {
            echo "unsuccess";   
        }
    }

    mysqli_close($conn);
?>