<?php

    require "connection.php";

    $senderUserId = $_POST['sender_user_id'];                           
    $receiverUserId = $_POST['receiver_user_id'];                  

    try 
    {
        $query = "insert into friendship(user_id, friend_id, status) VALUES (?, ?, 'pending')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $senderUserId, $receiverUserId);
        $stmt->execute();

        if($stmt->affected_rows > 0) 
        {
            //echo "Friend request sent";
            $response = array('status' => 'successfull', 'message' => 'Friend request sent');
            echo json_encode($response);
        } 
        else 
        {
            $response = array('status' => 'unsuccessfull', 'message' => 'failed');
            echo json_encode($response);
        }

        $stmt->close(); 
        $conn->close(); 
    } 
    catch(Exception $e) 
    {
        echo "Error";
    }
?>