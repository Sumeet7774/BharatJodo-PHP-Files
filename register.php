<?php

    require "connection.php";

    $username = $_POST['username'];
    $email_id = $_POST['email_id'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $check_sql = "SELECT * FROM users WHERE username = ? OR email_id = ? OR phone_number = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("sss", $username, $email_id, $phone_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) 
    {
        $response = array('status' => 'error', 'message' => 'User data already exists');
        echo json_encode($response);
    } 
    else 
    {
    
        $insert_sql = "INSERT INTO users (username, email_id, password, phone_number) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssss", $username, $email_id, $hashed_password, $phone_number);
    
        if($stmt->execute()) 
        {
            $response = array('status' => 'success', 'message' => 'registration successfull');
        } 
        else 
        {
            $response = array('status' => 'error', 'message' => 'registration failed', 'error' => $stmt->error);
        }
        echo json_encode($response);
    }

    $stmt->close();
    $conn->close();
    
?>
