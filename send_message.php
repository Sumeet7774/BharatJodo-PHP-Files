<?php

    require "connection.php";

    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $message_content = $_POST['message_content'];
    
    $query = "insert into messages(sender_id,receiver_id,message_content) VALUES ('$sender_id','$receiver_id','$message_content')";

    if(mysqli_query($conn,$query))
    {
        $response = array('status' => 'success', 'message' => 'Message sent');
    }
    else
    {
        $response = array('status' => 'error', 'message' => 'Failed to send message');
    }

    echo json_encode($response);
?>