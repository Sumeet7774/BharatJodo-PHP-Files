<?php

require 'connection.php';

$senderUserId = $_POST['sender_user_id'];                   // ID of the user sending the request
$receiverUserId = $_POST['receiver_user_id'];               // ID of the user receiving the request

    try 
    {
        $check_sql="select user_id, friend_id, status from friendship where (user_id = ? and friend_id = ?) or (user_id = ? AND friend_id = ?)";

        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("iiii", $senderUserId, $receiverUserId, $receiverUserId, $senderUserId);
        $stmt->execute();
        $result = $stmt->get_result();

        $status1 = null;
        $status2 = null;

        while ($row = $result->fetch_assoc()) 
        {
            if ($row['user_id'] == $senderUserId && $row['friend_id'] == $receiverUserId) 
            {
                $status1 = $row['status'];
            } 
            elseif ($row['user_id'] == $receiverUserId && $row['friend_id'] == $senderUserId) 
            {
                $status2 = $row['status'];
            }
        }

        if ($status1 === 'accepted' && $status2 === 'accepted') 
        {
            echo json_encode(['status' => 'accepted']);
        } 
        else if ($status1 === 'pending' || $status2 === 'pending') 
        {
            echo json_encode(['status' => 'pending']);
        } 
        else if ($status1 === 'rejected' || $status2 === 'rejected') 
        {
            echo json_encode(['status' => 'rejected']);
        } 
        else 
        {
            echo json_encode(['status' => 'no_relationship']);
        }

        $stmt->close();
        $conn->close();

    } 
    catch (Exception $e) 
    {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>