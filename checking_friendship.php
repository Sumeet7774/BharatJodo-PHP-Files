<?php

    require 'connection.php';

    $senderUserId = $_POST['sender_user_id'];                   // ID of the user sending the request
    $receiverUserId = $_POST['receiver_user_id'];               // ID of the user receiving the request

    try 
    {
        $check_sql = "select * from friendship WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("iiii", $senderUserId, $receiverUserId, $receiverUserId, $senderUserId);    
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            $currentStatus = $row['status'];

            if ($currentStatus == 'pending') 
            {
                echo json_encode(['status' => 'pending']);
            } 
            elseif ($currentStatus == 'accepted') 
            {
                echo json_encode(['status' => 'accepted']);
            }
            elseif ($currentStatus == 'rejected') 
            {
                echo json_encode(['status' => 'rejected']);
            }
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
        echo "Error: " . $e->getMessage();
    }
?>
