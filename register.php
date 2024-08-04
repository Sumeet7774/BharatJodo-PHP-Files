<?php
    require "connection.php";

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email_id = mysqli_real_escape_string($conn, $_POST['email_id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM users WHERE username='$username' OR email_id='$email_id' OR phone_number='$phone_number'";
    $check = mysqli_query($conn, $check_sql);

    if(mysqli_num_rows($check) > 0) 
    {
        $response = array('status' => 'error', 'message' => 'User data already exists');
        echo json_encode($response);
    } 
    else 
    {
        $query = "insert into users (username, email_id, password, phone_number) VALUES ('$username', '$email_id', '$hashed_password', '$phone_number')";
        
        if(mysqli_query($conn, $query)) 
        {
            $response = array('status' => 'success', 'message' => 'registration successfull');
        } 
        else 
        {
            $response = array('status' => 'error', 'message' => 'registration failed', 'error' => mysqli_error($conn));
        }
        echo json_encode($response);
    }

    mysqli_close($conn);
?>
