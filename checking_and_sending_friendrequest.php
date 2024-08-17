<?php

    require 'connection.php';

    $senderUserId = $_POST['sender_user_id']; // ID of the user sending the request
    $receiverUserId = $_POST['receiver_user_id']; // ID of the user receiving the request

    try 
    {
        $check_sql = "select * from friendships WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("iiii", $senderUserId, $receiverUserId, $receiverUserId, $senderUserId);    
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) 
        {
            // Users are already friends, fetch the current status
            $row = $result->fetch_assoc();
            $currentStatus = $row['status'];

            if ($currentStatus == 'pending') 
            {
                echo "Friend request is pending.";
            } 
            elseif ($currentStatus == 'accepted') 
            {
                echo "You are already friends.";
            }
            elseif ($currentStatus == 'rejected') 
            {
                echo "Friend request was rejected.";
            }
        } 
        else 
        {
            // Users are not friends, send a new friend request
            $sendFriendRequest = "insert into friendships (user_id, friend_id, status) VALUES (?, ?, 'pending')";
            $sendFriendStmt = $conn->prepare($sendFriendRequest);
            $sendFriendStmt->bind_param("ii", $senderUserId, $receiverUserId);
            $sendFriendStmt->execute();

            if ($sendFriendStmt->affected_rows > 0) 
            {
                echo "Friend request sent.";
            } 
            else 
            {
                echo "Failed to send friend request.";
            }
        }

        $stmt->close();
        $conn->close();
    } 
    catch (Exception $e) 
    {
        echo "Error: " . $e->getMessage();
    }
?>
