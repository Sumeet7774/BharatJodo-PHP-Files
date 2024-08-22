<?php

    require 'connection.php';

    $username = $_POST['username'];

    $check_sql = "select user_id, username, phone_number from users WHERE username = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    $response = array(
        'status' => 'found', 
        'message' => 'user found',
        'user_id' => $row['user_id'],
        'username' => $row['username'],
        'phone_number' => $row['phone_number']
    );
    echo json_encode($response);
} 
    else 
    {
        $response = array('status' => 'not found', 'message' => 'user not found');
        echo json_encode($response);
    }

    $stmt->close();
    $conn->close();
?>