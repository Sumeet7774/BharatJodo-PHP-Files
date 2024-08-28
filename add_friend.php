<?php

require "connection.php";

$senderUserId = $_POST['sender_user_id'];                           
$receiverUserId = $_POST['receiver_user_id'];                  

try 
{
    $checkQuery = "SELECT * FROM friendship WHERE user_id = ? AND friend_id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("ii", $senderUserId, $receiverUserId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $response = array('status' => 'unsuccessfull', 'message' => 'Friend request already exists');
        echo json_encode($response);
    } else {
        $query = "INSERT INTO friendship(user_id, friend_id, status) VALUES (?, ?, 'pending')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $senderUserId, $receiverUserId);
        $stmt->execute();

        if($stmt->affected_rows > 0) 
        {
            $response = array('status' => 'successfull', 'message' => 'Friend request sent');
            echo json_encode($response);
        } 
        else 
        {
            $response = array('status' => 'unsuccessfull', 'message' => 'Failed to send friend request');
            echo json_encode($response);
        }

        $stmt->close(); 
    }

    $checkStmt->close(); 
    $conn->close(); 
} 
catch(Exception $e) 
{
    $response = array('status' => 'error', 'message' => 'An error occurred');
    echo json_encode($response);
}
?>
