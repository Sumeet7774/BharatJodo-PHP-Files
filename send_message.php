<?php

    require 'connection.php';

    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $message_content = $_POST['message_content'];

    try 
    {
        $query = "INSERT INTO messages(sender_id, receiver_id, message_content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $sender_id, $receiver_id, $message_content);

        if ($stmt->execute()) 
        {
            $response = array('status' => 'success', 'message' => 'Message sent');
        } 
        else 
        {
            $response = array('status' => 'error', 'message' => 'Failed to send message');
        }

        echo json_encode($response);

        $stmt->close();
        $conn->close();
    } 
    catch (Exception $e) 
    {
        $response = array('status' => 'error', 'message' => 'Error: ' . $e->getMessage());
        echo json_encode($response);
    }
?>
